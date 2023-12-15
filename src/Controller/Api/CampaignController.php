<?php

namespace App\Controller\Api;

use App\Entity\Campaign;
use App\Repository\CampaignRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ValidatorInterface;

#[Route('/campaign')]
class CampaignController extends AbstractController
{
    /**
     * Create a new campaign.
     *
     * @param Request $request The HTTP request object.
     * @param EntityManagerInterface $entityManager The entity manager for database operations.
     * @param SerializerInterface $serializer The serializer for deserializing request data.
     * @param ValidatorInterface $validator The validator for validating the campaign data.
     *
     * @return JsonResponse A JSON response indicating the result of the creation.
     */
    #[Route('', name: 'campaign_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse {
        $campaignData = $request->getContent();

        try {
            $campaign = $serializer->deserialize($campaignData, Campaign::class, 'json');
        } catch (\Exception $e) {
            return $this->json(['error' => 'Invalid JSON: ' . $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        $errors = $validator->validate($campaign);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }
            return $this->json(['errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($campaign);
        $entityManager->flush();

        return $this->json(['message' => 'Campaign created successfully', 'campaign' => $campaign], JsonResponse::HTTP_CREATED);
    }

    /**
     * Read a specific campaign by ID.
     *
     * Retrieves the details of a specific campaign by its ID.
     *
     * @param Campaign $campaign The campaign entity retrieved by its ID.
     *
     * @return JsonResponse A JSON response containing the campaign details.
     */
    #[Route('/{id}', name: 'campaign_read', methods: ['GET'])]
    public function read(Campaign $campaign): JsonResponse {
        return $this->json($campaign);
    }

    /**
     * Update a specific campaign by ID.
     *
     * Updates an existing campaign with the data sent in the request body.
     *
     * @param Request $request The HTTP request object.
     * @param Campaign $campaign The campaign entity to update.
     * @param EntityManagerInterface $entityManager The entity manager for database operations.
     * @param SerializerInterface $serializer The serializer for deserializing request data.
     * @param ValidatorInterface $validator The validator for validating the campaign data.
     *
     * @return JsonResponse A JSON response indicating the result of the update.
     */
    #[Route('/{id}', name: 'campaign_update', methods: ['PUT'])]
    public function update(Request $request, Campaign $campaign, EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse {
        if (!$campaign) {
            return $this->json(['error' => 'Campaign not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $campaignData = $request->getContent();
        try {
            $serializer->deserialize($campaignData, Campaign::class, 'json', ['object_to_populate' => $campaign]);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Invalid JSON: ' . $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        $errors = $validator->validate($campaign);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }
            return $this->json(['errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
        }

        $entityManager->flush();

        return $this->json(['message' => 'Campaign updated successfully', 'campaign' => $campaign]);
    }

    /**
     * Delete a specific campaign by ID.
     *
     * Deletes a specific campaign by its ID.
     *
     * @param Campaign $campaign The campaign entity to delete.
     * @param EntityManagerInterface $entityManager The entity manager for database operations.
     *
     * @return JsonResponse A JSON response indicating the result of the deletion.
     */
    #[Route('/{id}', name: 'campaign_delete', methods: ['DELETE'])]
    public function delete(Campaign $campaign, EntityManagerInterface $entityManager): JsonResponse {
        if (!$campaign) {
            return $this->json(['error' => 'Campaign not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $entityManager->remove($campaign);
        $entityManager->flush();

        return $this->json(['message' => 'Campaign deleted successfully'], JsonResponse::HTTP_OK);
    }


    /**
     * List all campaigns.
     *
     * This method returns a list of all campaigns.
     *
     * @param CampaignRepository $repository The Campaign repository.
     *
     * @return JsonResponse A JSON response containing the list of campaigns.
     */
    #[Route('', name: 'campaign_list', methods: ['GET'])]
    public function list(CampaignRepository $repository): JsonResponse {
        $campaigns = $repository->findAll();
        return $this->json($campaigns, JsonResponse::HTTP_OK);
    }
}
