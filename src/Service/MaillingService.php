<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

/**
 * Service for sending emails.
 */
class MaillingService
{
    private $mailer;

    /**
     * Constructor.
     *
     * @param MailerInterface $mailer The Mailer interface to send emails.
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Send multiple emails in batches with a pause interval.
     *
     * @param array $emailDTOs An array of MaillingDTO objects.
     * @param int $batchSize The number of emails to send in each batch.
     * @param int $pauseInterval The pause interval (in seconds) between batches.
     */
    public function sendBulkEmails(array $emailDTOs, int $batchSize = 10, int $pauseInterval = 11): void
    {
        $emailBatches = array_chunk($emailDTOs, $batchSize);

        foreach ($emailBatches as $batch) {
            foreach ($batch as $emailDTO) {
                $email = (new TemplatedEmail())
                    ->from($emailDTO->from)
                    ->to(new Address($emailDTO->to))
                    ->subject($emailDTO->subject)
                    ->htmlTemplate('email/' . $emailDTO->template)
                    ->context([
                        'expiration_date' => new \DateTime('+7 days'),
                        'username' => $emailDTO->name,
                        'body' => $emailDTO->body,
                    ]);

                try {
                    $this->mailer->send($email);
                } catch (TransportExceptionInterface $e) {
                }
            }

            sleep($pauseInterval);
        }
    }
}
