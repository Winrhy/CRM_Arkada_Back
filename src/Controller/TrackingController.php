<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
}