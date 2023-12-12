<?php

namespace App\Controller\Api;

use App\Entity\Contact;
use App\Entity\Mail;
use App\Entity\MailTemplate;
use App\Entity\User;
use App\Repository\ContactRepository;
use App\Repository\MailRepository;
use App\Repository\MailTemplateRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use Symfony\Component\Serializer\SerializerInterface;
use ApiPlatform\Core\Annotation\ApiProperty;


#[Route('/mail', name: 'app_mail')]
class MailingController extends AbstractController
{
    /**
     * Sends an email using a specified template.
     *
     * @param MailerInterface $mailer The Mailer interface to send emails.
     * @param string $emailId Unique identifier of the email.
     * @param string $from Sender's email address.
     * @param string $to Recipient's email address.
     * @param string $subject Subject of the email.
     * @param string $template Name of the email template to be used.
     * @param string $name Name of the user the email is intended for.
     * @param string $body Body of the email (optional).
     * @return JsonResponse Returns a JSON response indicating success or failure of the email sending process.
     */
    private function sendEmail(MailerInterface $mailer,string $emailId, string $from, string $to, string $subject, string $template, string $name, string $body =''): JsonResponse
    {
        $templateDir = $this->getParameter('kernel.project_dir') . '/templates/email';
        $finder = new Finder();
        $files = $finder->in($templateDir)->files()->name('*.html.twig');
        $templates=[];
        foreach ($files as $file) {
            $templates[] = $file->getFilename();
        }

        $email = (new TemplatedEmail())
            ->from($from)
            ->to(new Address($to))
            ->subject($subject)

            ->htmlTemplate('email/' . $template)

            ->context([
                'expiration_date' => new \DateTime('+7 days'),
                'username' => $name,
                'body'=>$body,
                'email_id'=>$emailId
            ])
        ;
        try {
            $mailer->send($email);

            return $this->json([
                'message' => 'Email envoyé avec succès !',
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'error' => 'Une erreur est survenue lors de l\'envoi de l\'email.',
                'message' => $e->getMessage(),
                $emailId
            ], 500);
        }
    }

    #[Route('/create', name: 'app_mail_create')]
    public function createEmail(EntityManagerInterface $em, Request $request,MailerInterface $mailer, UserRepository $userRepository, MailRepository $mailRepository): JsonResponse
    {
        $user = $userRepository->findOneBy(['id'=>"018c5863-bccc-7b2b-93a7-94f4ff365f87"]);
        $data = json_decode($request->getContent(), true);
        $from = $data['from'];
        $to = $data['to'];
        $subject = $data['subject'] ?? 'Arkada Studio';
        $template = $data['template'] ?? 'signup.html.twig';
        $name = $data['name'];
        $body = $data['body'] ?? '';

        $email = new Mail();
        $email->setSubject($subject);
        $email->setRead(false);
        $email->setBody($body);
        $email->setReceiver($to);
        $email->setUserId($user);
        $email->setTimestamp(new \DateTimeImmutable());
        $email->setSenderMail('arkada@gmail.com');
        $email->setDeadPixelId(1);
        $em->persist($email);
        $em->flush();
        $emailId = $email->getId();

        $response = $this->sendEmail(
            $mailer,
            $emailId,
            $from,
            $to,
            $subject,
            $template,
            $name,
            $body
        );
        return $this->json($response);
    }
    #[Route('/send-template/{template_id}', name: 'app_mail_send_template')]
    public function sendTemplate($template_id, MailTemplateRepository $mailTemplateRepository, EntityManagerInterface $em, Request $request,MailerInterface $mailer, UserRepository $userRepository, ContactRepository $contactRepository, SerializerInterface $serializer):JsonResponse
    {
        $template = $mailTemplateRepository->findOneBy(['id'=>$template_id]);

//        var_dump($template);

        $response = [
            'status' => 'success',
            'message' => 'Modèle d\'e-mail créé avec succès',
        ];

        return $this->json($template->getBody());
    }


    #[Route('/single', name: 'app_mail_single')]
    public function singleEmail(Request $request,MailTemplateRepository $rep, EntityManagerInterface $em, MailRepository $mailRepository): JsonResponse
    {
        $emal = $mailRepository->findOneBy(['id'=>"018bf611-344a-7d18-af75-12bcfba983f0"]);
        return $this->json([$emal]);
//        $data = json_decode($request->getContent(), true);
//        $id = $data['id'];
//
//        $template = $rep->findOneBy(['id'=>$id]);
//        if (!$template) {
//            return $this->json(['error' => 'Email not found'], 404);
//        }
//        return $this->json([$template]);

//        $user = new User();
//        $user->setEmail('test');
//        $user->setFirstName('paul');
//        $user->setLastName('delamare');
//        $user->setCreatedAt(new \DateTimeImmutable());
//        $user->setRoles(['ROLE_USER']);
//        $user->setJwtToken('bedhgfyuefbeyhufbguye');
//
//        // Générer un mot de passe aléatoire et l'encoder
//        $plainPassword = 'paul1234';
//        $user->setPassword($plainPassword);
//
//        // Persistez l'utilisateur en base de données
//        $em->persist($user);
//        $em->flush();

//        return $this->json("Faux utilisateur créé avec succès !");
    }

}