<?php

namespace App\Controller\Api;

use App\Service\SegmentService;
use App\DTO\SegmentDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller for handling Segment entity operations.
 *
 * @Route("/segment")
 */
class SegmentController extends AbstractController
{
    private SegmentService $segmentService;

    /**
     * Constructor for SegmentController.
     *
     * @param SegmentService $segmentService The segment service.
     */
    public function __construct(SegmentService $segmentService)
    {
        $this->segmentService = $segmentService;
    }

}
