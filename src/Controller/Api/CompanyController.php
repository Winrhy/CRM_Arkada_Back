<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Company;
use App\Form\CompanyType;
use App\Service\CompanyService;

#[Route('/company')]
class CompanyController extends AbstractController
{
    private $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }


    /**
     * Create a new Company entity.
     *
     * This method handles the request to create a new Company. It processes the request data,
     * validates it, and persists the new Company entity to the database.
     *
     * @param Request $request The HTTP request object.
     * @return JsonResponse The response object with status code and message.
     */
    #[Route('', name: 'company_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $company = new Company();
        $form = $this->createForm(CompanyType::class, $company);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isSubmitted() && $form->isValid()) {
            $this->companyService->createCompany($company);
            return $this->json($company, Response::HTTP_CREATED);
        }

        return $this->json(['errors' => (string) $form->getErrors(true, false)], Response::HTTP_BAD_REQUEST);
    }


    /**
     * Read and return a specific Company entity.
     *
     * This method retrieves the details of a specific Company by its ID. If the Company is not found,
     * it returns a 404 Not Found response.
     *
     * @param int $id The ID of the Company.
     * @return JsonResponse The response object with the Company data or an error message.
     */
    #[Route('/{id}', name: 'company_read', methods: ['GET'])]
    public function read(int $id): JsonResponse
    {
        $company = $this->companyService->getCompany($id);

        if (!$company) {
            return $this->json(['error' => 'Company not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($company);
    }


    /**
     * Update a specific Company entity.
     *
     * This method updates an existing Company with the data sent in the request body.
     * If the Company is not found, it returns a 404 Not Found response.
     *
     * @param Request $request The HTTP request object.
     * @param int $id The ID of the Company to update.
     * @return JsonResponse The response object with the updated Company data or an error message.
     */
    #[Route('/{id}', name: 'company_update', methods: ['PUT'])]
    public function update(Request $request, int $id): JsonResponse
    {
        $company = $this->companyService->getCompany($id);

        if (!$company) {
            return $this->json(['error' => 'Company not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(CompanyType::class, $company);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isSubmitted() && $form->isValid()) {
            $this->companyService->updateCompany($company);
            return $this->json($company);
        }

        return $this->json(['errors' => (string) $form->getErrors(true, false)], Response::HTTP_BAD_REQUEST);
    }


    /**
     * Delete a specific Company entity.
     *
     * This method deletes a specific Company by its ID. If the Company is not found,
     * it returns a 404 Not Found response.
     *
     * @param int $id The ID of the Company to delete.
     * @return JsonResponse The response object with a success or error message.
     */
    #[Route('/{id}', name: 'company_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $company = $this->companyService->getCompany($id);

        if (!$company) {
            return $this->json(['error' => 'Company not found'], Response::HTTP_NOT_FOUND);
        }

        $this->companyService->deleteCompany($company);
        return $this->json(['message' => 'Company deleted successfully'], Response::HTTP_OK);
    }


    /**
     * List all Company entities.
     *
     * This method returns a list of all Company entities.
     *
     * @return JsonResponse The response object with an array of Company data.
     */
    #[Route('', name: 'company_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $companies = $this->companyService->getAllCompanies();
        return $this->json($companies);
    }
}
