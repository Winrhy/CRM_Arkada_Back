<?php
namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class EmailService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail(string $from, string $to, string $subject, string $template, string $name, string $body = ''): void
    {
        $email = (new TemplatedEmail())
            ->from($from)
            ->to(new Address($to))
            ->subject($subject)
            ->htmlTemplate('email/' . $template)
            ->context([
                'expiration_date' => new \DateTime('+7 days'),
                'username' => $name,
                'body' => $body,
            ]);

        $this->mailer->send($email);
    }
}