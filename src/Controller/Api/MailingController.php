<?php

namespace App\Controller\Api;

use App\Service\MaillingService;
use App\Controller\Api\UserController;
use App\DTO\MaillingDTO;
use App\Entity\Mail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
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
    public function createEmail(Request $request, MaillingService $maillingService, EntityManagerInterface $entityManager, JWTTokenManagerInterface $JWTManager, UserController $usermanager): JsonResponse {
        $emailData = json_decode($request->getContent(), true);
        $authorizationHeader = $request->headers->get('Authorization');
        $token = str_replace('Bearer ', '', $authorizationHeader);
        $decodedJwtToken = $this->jwtManager->decode($this->tokenStorageInterface->getToken());
        $uuid = $decodedJwtToken['uuid'];
        $user = $usermanager->getOneUserById($uuid,$entityManager);
        if ($emailData !== null) {
            foreach ($emailData['to'] as $recipient) {
                $maillingDTO = new MaillingDTO();
                $maillingDTO->from = $emailData['from'];
                $maillingDTO->to = $recipient;
                $maillingDTO->subject = $emailData['subject'] ?? 'Sujet par défaut';
                $maillingDTO->template = $emailData['template'] ?? 'default_template.html.twig';
                $maillingDTO->name = $emailData['name'] ?? 'Nom par défaut';
                $maillingDTO->body = $emailData['body'] ?? 'Corps du message par défaut';

                $mail = new Mail();
                $mail->setSubject($maillingDTO->subject);
                $mail->setBody($maillingDTO->body);
                //$mail->setTemplateId($maillingDTO->template);
                $mail->setTimestamp(new \DateTimeImmutable());
                $mail->setSenderMail($maillingDTO->from);
                $mail->setReceiver($maillingDTO->to);
                $mail->setRead(false);


                $entityManager->persist($mail);

                $bulkEmailDTOs[] = $maillingDTO;
            }

            $entityManager->flush();

            $maillingService->sendBulkEmails($bulkEmailDTOs);

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