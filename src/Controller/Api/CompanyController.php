<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/company')]
class CompanyController extends AbstractController
{

    /**
     * Create a new company.
     *
     * This method creates a new company entity from the request data,
     * validates it, and persists it to the database.
     *
     * @param Request                $request        The HTTP request object.
     * @param EntityManagerInterface $entityManager  The entity manager for database operations.
     * @param SerializerInterface    $serializer     The serializer for deserializing request data.
     * @param ValidatorInterface     $validator      The validator for validating the company data.
     *
     * @return JsonResponse A JSON response indicating the result of the creation.
     */
    #[Route('', name: 'company_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse {
        // Get JSON data from the request
        $companyData = $request->getContent();

        try {
            // Deserialize the data into a Company object
            $company = $serializer->deserialize($companyData, Company::class, 'json');
        } catch (\Exception $e) {
            // Handle deserialization errors
            return $this->json(['error' => 'Invalid JSON: ' . $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Validate the Company object
        $errors = $validator->validate($company);
        if (count($errors) > 0) {
            // If there are validation errors, return them
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }
            return $this->json(['errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
        }

        $company->setCreatedAt(new \DateTimeImmutable());
        $entityManager->persist($company);
        $entityManager->flush();

        return $this->json([
            'message' => 'Company created successfully',
            'company' => $company
        ], JsonResponse::HTTP_CREATED);
    }


    /**
     * Read a specific company by ID.
     *
     * This method retrieves the details of a specific company by its ID.
     *
     * @param Company $company The company entity retrieved by its ID.
     *
     * @return JsonResponse A JSON response containing the company details.
     */
    #[Route('/{id}', name: 'company_read', methods: ['GET'])]
    public function read(Company $company): JsonResponse {
        if (!$company) {
            return $this->json(['error' => 'Company not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        return $this->json([
            'id' => $company->getId(),
            'name' => $company->getName(),
            'address' => $company->getAddress(),
            'country' => $company->getCountry(),
            'city' => $company->getCity(),
            'postal_code' => $company->getPostalCode(),
            'created_at' => $company->getCreatedAt()->format('c'),
            'modified_at' => $company->getModifiedAt() ? $company->getModifiedAt()->format('c') : null,
            'sector' => $company->getSector(),
            'size' => $company->getSize(),
            'website' => $company->getWebsite(),
            'phone_number' => $company->getPhoneNumber(),
            'email' => $company->getEmail(),
            'type' => $company->getType()
        ]);
    }


    /**
     * Update a specific company by ID.
     *
     * This method updates an existing company with the data sent in the request body.
     *
     * @param Request                $request        The HTTP request object.
     * @param Company                $company        The company entity to update.
     * @param EntityManagerInterface $entityManager  The entity manager for database operations.
     * @param SerializerInterface    $serializer     The serializer for deserializing request data.
     * @param ValidatorInterface     $validator      The validator for validating the company data.
     *
     * @return JsonResponse A JSON response indicating the result of the update.
     */
    #[Route('/{id}', name: 'company_update', methods: ['PUT'])]
    public function update(Request $request, Company $company, EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse {
        {
            if (!$company) {
                return $this->json(['error' => 'Company not found'], JsonResponse::HTTP_NOT_FOUND);
            }

            $companyData = $request->getContent();

            try {
                // Deserialize the data into the existing Company object
                $serializer->deserialize($companyData, Company::class, 'json', ['object_to_populate' => $company]);
            } catch (\Exception $e) {
                // Handle deserialization errors
                return $this->json(['error' => 'Invalid JSON: ' . $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
            }

            $errors = $validator->validate($company);
            if (count($errors) > 0) {
                $errorMessages = [];
                foreach ($errors as $error) {
                    $errorMessages[$error->getPropertyPath()] = $error->getMessage();
                }
                return $this->json(['errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
            }

            $company->setModifiedAt(new \DateTimeImmutable());

            $entityManager->flush();

            return $this->json(['message' => 'Company updated successfully', 'company' => $company]);
        }
    }


    /**
     * Delete a specific company by ID.
     *
     * This method deletes a specific company by its ID.
     *
     * @param Company                $company        The company entity to delete.
     * @param EntityManagerInterface $entityManager  The entity manager for database operations.
     *
     * @return JsonResponse A JSON response indicating the result of the deletion.
     */
    #[Route('/{id}', name: 'company_delete', methods: ['DELETE'])]
    public function delete(Company $company, EntityManagerInterface $entityManager): JsonResponse {
        {
            if (!$company) {
                return $this->json(['error' => 'Company not found'], JsonResponse::HTTP_NOT_FOUND);
            }

            $entityManager->remove($company);
            $entityManager->flush();

            return $this->json(['message' => 'Company deleted successfully'], JsonResponse::HTTP_OK);
        }
    }


    /**
     * List all companies.
     *
     * This method returns a list of all companies.
     *
     * @param CompanyRepository $repository The Company repository.
     *
     * @return JsonResponse A JSON response containing the list of companies.
     */
    #[Route('', name: 'company_list', methods: ['GET'])]
    public function list(CompanyRepository $repository): JsonResponse {
        {
            $companies = $repository->findAll();
            $companyData = [];

            foreach ($companies as $company) {
                $companyData[] = [
                    'id' => $company->getId(),
                    'name' => $company->getName(),
                    'address' => $company->getAddress(),
                    'country' => $company->getCountry(),
                    'city' => $company->getCity(),
                    'postal_code' => $company->getPostalCode(),
                    'created_at' => $company->getCreatedAt() ? $company->getCreatedAt()->format('c') : null,
                    'modified_at' => $company->getModifiedAt() ? $company->getModifiedAt()->format('c') : null,
                    'sector' => $company->getSector(),
                    'size' => $company->getSize(),
                    'website' => $company->getWebsite(),
                    'phone_number' => $company->getPhoneNumber(),
                    'email' => $company->getEmail(),
                    'type' => $company->getType()
                ];
            }

            return $this->json($companyData);
        }
    }
}
