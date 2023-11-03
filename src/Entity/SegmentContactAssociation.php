<?php

namespace App\Entity;

use App\Repository\SegmentContactAssociationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV6 as Uuid;

#[ORM\Entity(repositoryClass: SegmentContactAssociationRepository::class)]
class SegmentContactAssociation
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\ManyToOne(inversedBy: 'segmentContactAssociations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Segment $segment_id = null;

    #[ORM\ManyToOne(inversedBy: 'segmentContactAssociations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Contact $contact_id = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getSegmentId(): ?Segment
    {
        return $this->segment_id;
    }

    public function setSegmentId(?Segment $segment_id): static
    {
        $this->segment_id = $segment_id;

        return $this;
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
}
