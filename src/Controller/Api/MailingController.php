<?php

namespace App\Controller\Api;

use App\Repository\UserRepository;
use App\Service\MaillingService;
use App\DTO\MaillingDTO;
use App\Entity\Mail;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


#[Route('/mail', name: 'app_mail')]
class MailingController extends AbstractController
{
    private $MaillingService;

    /**
     * Constructor.
     *
     * @param MaillingService $MaillingService Service for sending emails.
     */
    public function __construct(MaillingService $MaillingService, TokenStorageInterface $tokenStorageInterface, JWTTokenManagerInterface $jwtManager)
    {
        $this->MaillingService = $MaillingService;
        $this->jwtManager = $jwtManager;
        $this->tokenStorageInterface = $tokenStorageInterface;
    }

    /**
     * Creates and sends an email from a user-defined payload.
     *
     * This method receives an HTTP POST request with JSON data containing email parameters.
     * It creates an email based on the provided data and sends it using the MaillingService.
     *
     * @param Request $request The HTTP request object containing email data in JSON format.
     *
     * @return JsonResponse Returns a JSON response after creating and sending the email.
     */
    #[Route('/create', name: 'app_mail_create')]
    public function createEmail(Request $request, MaillingService $maillingService, EntityManagerInterface $entityManager,UserRepository $userRepository): JsonResponse {
        $emailData = json_decode($request->getContent(), true);

        if ($emailData !== null) {
            foreach ($emailData['to'] as $recipient) {
                $maillingDTO = new MaillingDTO();
                $maillingDTO->from = $emailData['senderMail'];
                $maillingDTO->to = $recipient['email'];
                $maillingDTO->subject = $emailData['subject'] ?? 'Sujet par défaut';
                $maillingDTO->template = $emailData['templateName'] ?? 'default_template.html.twig';
                $maillingDTO->body = $emailData['body'] ?? 'Corps du message par défaut';
                $maillingDTO->name = $recipient['firstname'] ?? '';
                $maillingDTO->last_name=$recipient['lastname'] ?? '';
                $maillingDTO->password = $emailData['password'] ??'';


                $decodedJwtToken = $this->jwtManager->decode($this->tokenStorageInterface->getToken());
                $user = $userRepository->findOneBy(['email' => $decodedJwtToken['username']]);

                $mail = new Mail();
                $mail->setSubject($maillingDTO->subject);
                $mail->setBody($maillingDTO->body);
                $mail->setTimestamp(new \DateTimeImmutable());
                $mail->setSenderMail($maillingDTO->from);
                $mail->setReceiver($maillingDTO->to);
                $mail->setRead(false);
                $mail->setUserId($user);

                $entityManager->persist($mail);

                $maillingDTO->email_id=$mail->getId();
                $bulkEmailDTOs[] = $maillingDTO;
            }

            $entityManager->flush();

            $ok = $maillingService->sendBulkEmails($bulkEmailDTOs);
            return $this->json($ok);
            return $this->json([
                'message' => 'Emails envoyés avec succès!',
            ]);
        } else {
            return $this->json([
                'message' => 'Données JSON invalides dans la requête.',
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}