<?php

namespace App\Entity;

use App\Repository\SegmentCampaignAssociationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV6 as Uuid;

#[ORM\Entity(repositoryClass: SegmentCampaignAssociationRepository::class)]
class SegmentCampaignAssociation
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\ManyToOne(inversedBy: 'segmentCampaignAssociations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Segment $segment_id = null;

    #[ORM\ManyToOne(inversedBy: 'segmentCampaignAssociations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Campaign $campaign_id = null;

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

    public function getCampaignId(): ?Campaign
    {
        return $this->campaign_id;
    }

    public function setCampaignId(?Campaign $campaign_id): static
    {
        $this->campaign_id = $campaign_id;

        return $this;
    }
}
