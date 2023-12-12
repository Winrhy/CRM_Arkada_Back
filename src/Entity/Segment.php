<?php

namespace App\Entity;

use App\Repository\SegmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV7 as Uuid;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;

#[ApiResource(operations: [
    new Get(),
    new Post(),
    new Post(),
    new Put(),
    new Delete(),
    new GetCollection()
])]

#[ORM\Entity(repositoryClass: SegmentRepository::class)]
class Segment
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $criterias = null;

    #[ORM\OneToMany(mappedBy: 'segment_id', targetEntity: SegmentContactAssociation::class)]
    private Collection $segmentContactAssociations;

    #[ORM\OneToMany(mappedBy: 'segment_id', targetEntity: SegmentCampaignAssociation::class)]
    private Collection $segmentCampaignAssociations;

    public function __construct()
    {
        $this->segmentContactAssociations = new ArrayCollection();
        $this->segmentCampaignAssociations = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCriterias(): ?string
    {
        return $this->criterias;
    }

    public function setCriterias(string $criterias): static
    {
        $this->criterias = $criterias;

        return $this;
    }

    /**
     * @return Collection<int, SegmentContactAssociation>
     */
    public function getSegmentContactAssociations(): Collection
    {
        return $this->segmentContactAssociations;
    }

    public function addSegmentContactAssociation(SegmentContactAssociation $segmentContactAssociation): static
    {
        if (!$this->segmentContactAssociations->contains($segmentContactAssociation)) {
            $this->segmentContactAssociations->add($segmentContactAssociation);
            $segmentContactAssociation->setSegmentId($this);
        }

        return $this;
    }

    public function removeSegmentContactAssociation(SegmentContactAssociation $segmentContactAssociation): static
    {
        if ($this->segmentContactAssociations->removeElement($segmentContactAssociation)) {
            // set the owning side to null (unless already changed)
            if ($segmentContactAssociation->getSegmentId() === $this) {
                $segmentContactAssociation->setSegmentId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SegmentCampaignAssociation>
     */
    public function getSegmentCampaignAssociations(): Collection
    {
        return $this->segmentCampaignAssociations;
    }

    public function addSegmentCampaignAssociation(SegmentCampaignAssociation $segmentCampaignAssociation): static
    {
        if (!$this->segmentCampaignAssociations->contains($segmentCampaignAssociation)) {
            $this->segmentCampaignAssociations->add($segmentCampaignAssociation);
            $segmentCampaignAssociation->setSegmentId($this);
        }

        return $this;
    }

    public function removeSegmentCampaignAssociation(SegmentCampaignAssociation $segmentCampaignAssociation): static
    {
        if ($this->segmentCampaignAssociations->removeElement($segmentCampaignAssociation)) {
            // set the owning side to null (unless already changed)
            if ($segmentCampaignAssociation->getSegmentId() === $this) {
                $segmentCampaignAssociation->setSegmentId(null);
            }
        }

        return $this;
    }
}
