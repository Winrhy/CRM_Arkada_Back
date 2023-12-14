<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SegmentController extends AbstractController
{
    #[Route('/segment', name: 'app_segment')]
    public function index(): Response
    {
        return $this->render('segment/index.html.twig', [
            'controller_name' => 'SegmentController',
        ]);
    }
}
