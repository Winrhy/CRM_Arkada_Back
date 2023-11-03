<?php

namespace App\Entity;

use App\Repository\ContactCompanyAssociationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV6 as Uuid;

#[ORM\Entity(repositoryClass: ContactCompanyAssociationRepository::class)]
class ContactCompanyAssociation
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\ManyToOne(inversedBy: 'contactCompanyAssociations')]
    private ?Contact $contact_id = null;

    #[ORM\ManyToOne(inversedBy: 'contactCompanyAssociations')]
    private ?Company $company_id = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getContactId(): ?Contact
    {
        return $this->contact_id;
    }

    public function setContactId(?Contact $contact_id): static
    {
        $this->contact_id = $contact_id;

        return $this;
    }

    public function getCompanyId(): ?Company
    {
        return $this->company_id;
    }

    public function setCompanyId(?Company $company_id): static
    {
        $this->company_id = $company_id;

        return $this;
    }
}
