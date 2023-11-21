<?php

namespace App\Controller;

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
            //... executes some logic to retrieve the email and mark it as opened
        }
        return new TransparentPixelResponseController();
    }

    #[Route('/tracking_pixel/{email_id}', name: 'tracking_pixel')]
    public function pixel($email_id):Response
    {
        $pixelContent = base64_decode('R0lGODlhAQABAIAAAAUEBAAAACwAAAAAAQABAAACAkQBADs=');

        $response = new Response($pixelContent);
        $response->headers->set('Content-Type', 'image/gif');

        return $response;
    }
}