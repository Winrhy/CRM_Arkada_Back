<?php

namespace App\Entity;

use App\Repository\CtaStatsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV6 as Uuid;

#[ORM\Entity(repositoryClass: CtaStatsRepository::class)]
class CtaStats
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $total_views = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $total_clicks = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $stat_date = null;

    #[ORM\ManyToOne(inversedBy: 'ctaStats')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cta $cta_id = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getTotalViews(): ?string
    {
        return $this->total_views;
    }

    public function setTotalViews(string $total_views): static
    {
        $this->total_views = $total_views;

        return $this;
    }

    public function getTotalClicks(): ?string
    {
        return $this->total_clicks;
    }

    public function setTotalClicks(string $total_clicks): static
    {
        $this->total_clicks = $total_clicks;

        return $this;
    }

    public function getStatDate(): ?\DateTimeImmutable
    {
        return $this->stat_date;
    }

    public function setStatDate(\DateTimeImmutable $stat_date): static
    {
        $this->stat_date = $stat_date;

        return $this;
    }

    public function getCtaId(): ?Cta
    {
        return $this->cta_id;
    }

    public function setCtaId(?Cta $cta_id): static
    {
        $this->cta_id = $cta_id;

        return $this;
    }
}
