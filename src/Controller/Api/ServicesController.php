<?php

namespace App\Controller\Api;

use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FilterController extends AbstractController
{
    #[Route('/filter', name: 'contact_filter', methods: ['GET'])]
    public function filter(Request $request, ContactRepository $repository): JsonResponse
    {
        $filterCriteria = $request->query->all();

        $allowedCriteria = $this->getAllowedFilterCriteria();

        $validFilterCriteria = array_intersect_key($filterCriteria, array_flip($allowedCriteria));

        try {
            $filteredContacts = $repository->findBy($validFilterCriteria);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $filteredContactData = [];
        foreach ($filteredContacts as $contact) {
            $filteredContactData[] = [
                'id' => $contact->getId(),
                'first_name' => $contact->getFirstName(),
                'country' => $contact->getCountry(),
            ];
        }

        return $this->json($filteredContactData);
    }

    /**
     * Get the allowed filter criteria based on your preferences.
     *
     * @return array
     */
    private function getAllowedFilterCriteria(): array
    {
        return ['country'];
    }
}
