<?php

namespace App\Service;

use App\Entity\Company;
use App\Form\CompanyType;
use App\DTO\CompanyDTO;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;

class CompanyService
{
    private $companyRepository;
    private $entityManager;

    public function __construct(CompanyRepository $companyRepository, EntityManagerInterface $entityManager)
    {
        $this->companyRepository = $companyRepository;
        $this->entityManager = $entityManager;
    }

    public function createCompany(Company $company): void
    {
        $this->entityManager->persist($company);
        $this->entityManager->flush();
    }

    public function updateCompany(Company $company): void
    {
        $this->entityManager->flush();
    }

    public function deleteCompany(Company $company): void
    {
        $this->entityManager->remove($company);
        $this->entityManager->flush();
    }

    public function getCompany(int $id): ?Company
    {
        return $this->companyRepository->find($id);
    }

    public function getAllCompanies(): array
    {
        return $this->companyRepository->findAll();
    }

}