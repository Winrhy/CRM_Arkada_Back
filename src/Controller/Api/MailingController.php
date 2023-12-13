<?php

namespace App\Controller\Api;

use App\Entity\Mail;
use App\Repository\MailRepository;
use App\Repository\MailTemplateRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
     *
     * @return JsonResponse Returns a JSON response indicating success or failure of the email sending process.
     */
    private function sendEmail(
        MailerInterface $mailer,
        string $emailId,
        string $from,
        string $to,
        string $subject,
        string $template,
        string $name,
        string $body = ''
    ): JsonResponse {
        $templateDir = $this->getParameter('kernel.project_dir') . '/templates/email';

        $email = (new TemplatedEmail())
            ->from($from)
            ->to(new Address($to))
            ->subject($subject)
            ->htmlTemplate('email/' . $template)
            ->context([
                'expiration_date' => new \DateTime('+7 days'),
                'username' => $name,
                'body' => $body,
                'email_id' => $emailId,
            ]);

        try {
            $mailer->send($email);

            return $this->json([
                'message' => 'Email envoyé avec succès !',
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'error' => 'Une erreur est survenue lors de l\'envoi de l\'email.',
                'message' => $e->getMessage(),
                'emailId' => $emailId,
            ], 500);
        }
    }

    /**
     * Creates and sends an email from a user-defined payload.
     *
     * @param EntityManagerInterface $em Entity Manager for database interactions.
     * @param Request $request The HTTP request object containing email data.
     * @param MailerInterface $mailer Mailer service for sending emails.
     * @param UserRepository $userRepository Repository for user entity.
     * @param MailRepository $mailRepository Repository for mail entity.
     *
     * @return JsonResponse Returns a JSON response after creating and sending the email.
     */
    #[Route('/create', name: 'app_mail_create')]
    public function createEmail(
        EntityManagerInterface $em,
        Request $request,
        MailerInterface $mailer,
        UserRepository $userRepository,
        MailRepository $mailRepository
    ): JsonResponse {
        $user = $userRepository->findOneBy(['id' => '018c5863-bccc-7b2b-93a7-94f4ff365f87']);
        $data = json_decode($request->getContent(), true);
        $from = $data['from'];
        $to = $data['to'];
        $subject = $data['subject'] ?? 'Arkada Studio';
        $template = $data['template'] ?? 'signup.html.twig';
        $name = $data['name'];
        $body = $data['body'] ?? '';

        $email = new Mail();
        $email->setSubject($subject)
            ->setRead(false)
            ->setBody($body)
            ->setReceiver($to)
            ->setUserId($user)
            ->setTimestamp(new \DateTimeImmutable())
            ->setSenderMail('arkada@gmail.com')
            ->setDeadPixelId(1);

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

    /**
     * Sends an email using a predefined template from the database.
     *
     * @param mixed $template_id The ID of the email template.
     * @param MailTemplateRepository $mailTemplateRepository Repository for mail template entity.
     *
     * @return JsonResponse Returns a JSON response with the email template body or error message.
     */
    #[Route('/send-template/{template_id}', name: 'app_mail_send_template')]
    public function sendTemplate(
        $template_id,
        MailTemplateRepository $mailTemplateRepository
    ): JsonResponse {
        $template = $mailTemplateRepository->findOneBy(['id' => $template_id]);

        if ($template) {
            return $this->json(['status' => 'success', 'message' => 'Modèle d\'e-mail créé avec succès']);
        }

        return $this->json(['status' => 'error', 'message' => 'Template not found'], 404);
    }

    /**
     * Fetches a single email entity based on a given ID and returns its details.
     *
     * @param Request $request HTTP request containing the email ID.
     * @param MailRepository $mailRepository Repository for mail entity.
     *
     * @return JsonResponse Returns a JSON response with email details or an error message.
     */
    #[Route('/single', name: 'app_mail_single')]
    public function singleEmail(Request $request, MailRepository $mailRepository): JsonResponse {
        $email = $mailRepository->findOneBy(['id' => '018bf611-344a-7d18-af75-12bcfba983f0']);

        if ($email) {
            return $this->json([$email]);
        }

        return $this->json(['status' => 'error', 'message' => 'Email not found'], 404);
    }
}
