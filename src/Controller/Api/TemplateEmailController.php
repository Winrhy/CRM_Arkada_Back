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

#[Route('/template', name: 'app_template_email')]
class TemplateEmailController extends AbstractController
{

    #[Route('/templates', name: 'app_templates_index', methods: ['GET'])]
    public function index(MailTemplateRepository $templateRepository): JsonResponse
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
            'username' => 'John Doe',
            'body' => 'Jane',
            'email_id'=>'000'
        ]);
        return new Response($html);
    }

    #[Route('/create', name: 'app_template_create', methods: ['POST'])]
    public function createTemplate(EntityManagerInterface $em, Request $request, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->findOneBy(['id'=>"018bf293-b164-7c7b-affe-1c05d452ac6e"]);
        $data = json_decode($request->getContent(), true);
        $subject = $data['subject'] ?? 'Arkada Studio';
        $body = $data['body'] ?? '';
        $from = $data['from'] ?? 'arkada@gmail.com';
        $template = $data['template'] ?? 'signup.html.twig';

        $email = new MailTemplate();
        $email->setSubject($subject);
        $email->setBody($body);
        $email->setUserId($user);
        $email->setSenderMail($from);
        $email->setTemplateName($template);
        $em->persist($email);
        $em->flush();

        $response = [
            'status' => 'success',
            'message' => 'Modèle d\'e-mail créé avec succès'
        ];
        return $this->json($response);
    }

    #[Route('/update/{id}', name: 'app_template_update', methods: ['PUT'])]
    public function updateTemplate(EntityManagerInterface $em, Request $request, UserRepository $userRepository,string $id, MailTemplateRepository $templateRepository): JsonResponse
    {
        $user = $userRepository->findOneBy(['id' => "018bf293-b164-7c7b-affe-1c05d452ac6e"]);
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
        $user = $userRepository->findOneBy(['id' => "018bf293-b164-7c7b-affe-1c05d452ac6e"]);

        if (!$this->getUser() || !$this->getUser()->isGranted('ROLE_ADMIN')) {
            return $this->json(['status' => 'error', 'message' => 'Vous n\'avez pas les droits pour supprimer ce modèle'], 403);
        }

        $template = $templateRepository->findOneBy(['id'=>$id]);
        if (!$template) {
            return $this->json(['status' => 'error', 'message' => 'Modèle d\'e-mail introuvable'], 404);
        }

        $em->remove($template);
        $em->flush();

        return $this->json(['status' => 'success', 'message' => 'Modèle d\'e-mail supprimé avec succès'], 200);
    }

}
