<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;


#[Route('/mail', name: 'app_mail')]
class MailingController extends AbstractController
{
    #[Route('/send', name: 'app_mail_send')]
    public function sendEmail(MailerInterface $mailer): JsonResponse
    {
        $email = (new TemplatedEmail())
            ->from('fabien@example.com')
            ->to(new Address('ryan@example.com'))
            ->subject('Thanks for signing up!')

            // path of the Twig template to render
            ->htmlTemplate('emails/signup.html.twig')

            // pass variables (name => value) to the template
            ->context([
                'expiration_date' => new \DateTime('+7 days'),
                'username' => 'foo',
            ])
        ;
        $mailer->send($email);
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/MailingController.php',
        ]);
    }

    #[Route('/create', name: 'app_mail_create')]
    public function createEmail(EntityManagerInterface $em, Request $request,MailerInterface $mailer): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $name = $data['name'];
        $subject = $data['subject'];
        $body = $data['body'];

        $template = new Emailtemplate();
        $template->setName($name);
        $template->setSubject($subject);
        $template->setBody($body);
        $em->persist($template);
        $em->flush();

        return $this->json(['username' => $template->getPassword(),'password' => $template->getBody()]);
    }
    #[Route('/single', name: 'app_mail_single')]
    public function singleEmail(EntityManagerInterface $em, Request $request,MailerInterface $mailer): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $id = $data['id'];

        $templates = new EmailTemplate();
//        $template = $templates->findOneBy

        return $this->json(['username' => $template->getPassword(),'password' => $template->getBody()]);
    }
}