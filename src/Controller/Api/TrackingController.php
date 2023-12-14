<?php

namespace App\Controller\Api;

use App\Repository\MailRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class TrackingController extends AbstractController
{
    #[Route('/track.gif', name: 'app_track')]
    public function trackEmailAction(Request $request)
    {
        $id = $request->query->get('id');
        if(null !== $id) {
        }
        return new TransparentPixelResponseController();
    }

    #[Route('/tracking_pixel/{email_id}', name: 'tracking_pixel')]
    public function pixel($email_id, MailRepository $mailRepository, EntityManagerInterface $em):Response
    {
        $email = $mailRepository->findOneBy(['id'=>$email_id]);
        $email->setRead(true);
        $em->persist($email);
        $em->flush();
        $pixelContent = base64_decode('R0lGODlhAQABAIAAAAUEBAAAACwAAAAAAQABAAACAkQBADs=');

        $response = new Response($pixelContent);
        $response->headers->set('Content-Type', 'image/gif');

        return $this->json('ok');
    }

}