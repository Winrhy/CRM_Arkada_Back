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

    /**
     * Creates a new Segment entity from the request data.
     *
     * @Route("/", name="create_segment", methods={"POST"})
     * @param Request $request The HTTP request.
     * @return Response The HTTP response.
     */
    public function createSegment(Request $request): Response
    {
        $segmentDTO = $this->jsonToObject($request->getContent(), SegmentDTO::class);
        $segment = $this->segmentService->createSegment($segmentDTO);
        return $this->json($segment, Response::HTTP_CREATED);
    }


}
