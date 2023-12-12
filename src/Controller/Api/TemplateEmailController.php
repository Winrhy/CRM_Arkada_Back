<?php

namespace App\Controller\Api;

use App\Entity\MailTemplate;
use App\Repository\MailTemplateRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


#[Route('/template', name: 'app_template_email')]
class TemplateEmailController extends AbstractController
{

    #[Route('/templates', name: 'app_templates_index', methods: ['GET'])]
    public function index(MailTemplateRepository $templateRepository)
    {
        $templates = $templateRepository->findAll();
        return $this->json($templates);
    }

    #[Route('/single/{id}', name: 'app_templates_show', methods: ['GET'])]
    public function show(MailTemplateRepository $templateRepository, string $id):Response
    {
        $template = $templateRepository->findOneBy(['id' => $id]);
        if (!$template) {
            return new Response('', 404);
        }
        $templateDir = $this->getParameter('kernel.project_dir') . '/templates/email';
        $templateFile = $templateDir . '/' . $template->getTemplateName();
        if (!file_exists($templateFile)) {
            return new Response('', 404);
        }
        $html = $this->render('email/'.$template->getTemplateName(), [
            'username' => 'Paul Posware',
            'body' => $template->getBody(),
        ]);
        return $html;
    }

    #[Route('/create', name: 'app_template_create', methods: ['POST'])]
    public function createTemplate(EntityManagerInterface $em, Request $request, UserRepository $userRepository, JWTTokenManagerInterface $jwtManager, TokenStorageInterface $tokenStorage): JsonResponse
    {
        try {
            $token = $request->headers->get('Authorization');
            $jwtToken = str_replace('Bearer ', '', $token);
            $user = $userRepository->findOneBy(['jwt_token' => $jwtToken]);
            $data = json_decode($request->getContent(), true);
            $name = $data['name'];
            $subject = $data['subject'] ;
            $body = $data['body'];
            $from = $data['from'] ?? 'arkada@gmail.com';
            $template = $data['design'];
            $template .= '.html.twig';
            $projectDir = $this->getParameter('kernel.project_dir');

            if (!$user) {
                throw new \Exception('Utilisateur introuvable.');
            }

            $templatePath = $projectDir . '/templates/email/' . $template;

            if (!file_exists($templatePath)) {
                throw new \Exception("Le template $template n'existe pas.");
            }

            $email = new MailTemplate();
            $email->setSubject($subject);
            $email->setBody($body);
            $email->setUserId($user);
            $email->setSenderMail($from);
            $email->setTemplateName($template);
            $email->setName($name);
            $em->persist($email);
            $em->flush();

            $response = [
                'status' => 'success',
                'message' => 'Modèle d\'e-mail créé avec succès'
            ];
            return $this->json($response);

        } catch (\Exception $e) {
            $errorResponse = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
            return $this->json($errorResponse, JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/update/{id}', name: 'app_template_update', methods: ['PUT'])]
    public function updateTemplate(EntityManagerInterface $em, Request $request, UserRepository $userRepository,string $id, MailTemplateRepository $templateRepository): JsonResponse
    {
        $user = $userRepository->findOneBy(['id' => "018c5a9f-15ea-7721-8139-0f8bc952c2a5"]);
        $data = json_decode($request->getContent(), true);
        $subject = $data['subject'] ?? 'Arkada Studio';
        $body = $data['body'] ?? '';
        $from = $data['from'] ?? 'arkada@gmail.com';
        $template = $data['template'] ?? 'signup.html.twig';

        $templateUpdate = $templateRepository->findOneBy(['id'=>$id]);
        if (!$templateUpdate) {
            return $this->json(['status' => 'error', 'message' => 'Modèle d\'e-mail introuvable'], 404);
        }

        $templateUpdate->setSubject($subject);
        $templateUpdate->setBody($body);
        $templateUpdate->setUserId($user);
        $templateUpdate->setSenderMail($from);
        $templateUpdate->setTemplateName($template);
        $em->flush();
        $response = [
            'status' => 'success',
            'message' => 'Modèle d\'e-mail mis à jour avec succès'
        ];
        return $this->json($response);
    }

    #[Route('/delete/{id}', name: 'app_template_delete', methods: ['DELETE', 'GET'])]
    public function deleteTemplate(EntityManagerInterface $em, MailTemplateRepository $templateRepository, UserRepository $userRepository, string $id): JsonResponse
    {
//        if (!$this->getUser() || !$this->getUser()->isGranted('ROLE_ADMIN')) {
//            return $this->json(['status' => 'error', 'message' => 'Vous n\'avez pas les droits pour supprimer ce modèle'], 403);
//        }

        $template = $templateRepository->findOneBy(['id'=>$id]);
        if (!$template) {
            return $this->json(['status' => 'error', 'message' => 'Modèle d\'e-mail introuvable'], 404);
        }

        $em->remove($template);
        $em->flush();

        return $this->json(['status' => 'success', 'message' => 'Modèle d\'e-mail supprimé avec succès'], 200);
    }

    #[Route('/design', name: 'app_templates_design', methods: ['GET'])]
    public function getTemplateDesign(MailTemplateRepository $templateRepository):JsonResponse
    {
        $cheminTemplatesEmail = $this->getParameter('kernel.project_dir') . '/templates/email';
        $finder = new Finder();
        $fichiersEmail = $finder->files()
            ->in($cheminTemplatesEmail)
            ->name('*.html.twig')
            ->notPath('/layout/');

        $designs = [];

        foreach ($fichiersEmail as $fichier) {
            $nameWithoutExtension = str_replace('.html.twig', '', $fichier->getFilename());
            $designs[] = $nameWithoutExtension;
        }
        return $this->json($designs);
    }

}
