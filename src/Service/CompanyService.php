<?php

namespace App\Service;

use App\Entity\Company;
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
        // Vous pouvez ajouter ici de la logique supplémentaire avant la persistance
        $this->entityManager->persist($company);
        $this->entityManager->flush();
    }

    public function updateCompany(Company $company): void
    {
        // La mise à jour est généralement gérée automatiquement, mais vous pouvez ajouter de la logique ici si nécessaire
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