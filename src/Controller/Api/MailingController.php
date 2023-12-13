<?php

namespace App\Controller\Api;

use App\Service\MaillingService;
use App\DTO\MaillingDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/mail', name: 'app_mail')]
class MailingController extends AbstractController
{
    private $MaillingService;

    /**
     * Constructor.
     *
     * @param MaillingService $MaillingService Service for sending emails.
     */
    public function __construct(MaillingService $MaillingService)
    {
        $this->MaillingService = $MaillingService;
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
    public function createEmail(Request $request, MaillingService $maillingService): JsonResponse
    {
        $emailData = json_decode($request->getContent(), true);

        if ($emailData !== null) {

            $maillingDTOs = [];

            $toRecipients = $emailData['to'];
            foreach ($toRecipients as $recipient) {
                print('test');
                $maillingDTO = new MaillingDTO();
                $maillingDTO->from = $emailData['from'];
                $maillingDTO->to = $recipient;
                $maillingDTO->subject = $emailData['subject'] ?? 'Sujet par défaut';
                $maillingDTO->template = $emailData['template'] ?? 'default_template.html.twig';
                $maillingDTO->name = $emailData['name'] ?? 'Nom par défaut';
                $maillingDTO->body = $emailData['body'] ?? 'Corps du message par défaut';
                $bulkEmailDTOs[] = $maillingDTO;
            }

            // Envoie des emails en utilisant la méthode sendBulkEmails du service
            $maillingService->sendBulkEmails($bulkEmailDTOs);

            return $this->json([
                'message' => 'Emails envoyés avec succès!',
            ]);
        } else {
            // Gérer le cas où $emailData est null
            return $this->json([
                'message' => 'Données JSON invalides dans la requête.',
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}