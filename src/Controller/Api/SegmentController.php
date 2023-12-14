<?php

namespace App\Controller;

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

    /**
     * Retrieves a Segment entity by its ID.
     *
     * @Route("/{id}", name="get_segment", methods={"GET"})
     * @param string $id The Segment entity ID.
     * @return Response The HTTP response.
     */
    public function getSegment(string $id): Response
    {
        $segment = $this->segmentService->getSegment($id);
        return $this->json($segment);
    }

    /**
     * Updates an existing Segment entity identified by ID.
     *
     * @Route("/{id}", name="update_segment", methods={"PUT"})
     * @param string $id The Segment entity ID.
     * @param Request $request The HTTP request.
     * @return Response The HTTP response.
     */
    public function updateSegment(string $id, Request $request): Response
    {
        $segmentDTO = $this->jsonToObject($request->getContent(), SegmentDTO::class);
        $segment = $this->segmentService->updateSegment($id, $segmentDTO);
        return $this->json($segment);
    }

    /**
     * Deletes a Segment entity identified by ID.
     *
     * @Route("/{id}", name="delete_segment", methods={"DELETE"})
     * @param string $id The Segment entity ID.
     * @return Response The HTTP response.
     */
    public function deleteSegment(string $id): Response
    {
        $this->segmentService->deleteSegment($id);
        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Helper function to deserialize JSON content to an object.
     *
     * @param string $json The JSON string.
     * @param string $class The class to deserialize into.
     * @return object The deserialized object.
     */
    private function jsonToObject(string $json, string $class)
    {
        return $this->get('serializer')->deserialize($json, $class, 'json');
    }
}
