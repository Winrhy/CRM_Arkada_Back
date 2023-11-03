<?php

namespace App\Entity;

use App\Repository\FormStatsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV6 as Uuid;

#[ORM\Entity(repositoryClass: FormStatsRepository::class)]
class FormStats
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $total_views = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $total_submits = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $stat_date = null;

    #[ORM\ManyToOne(inversedBy: 'formStats')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Form $form_id = null;

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

    public function getTotalSubmits(): ?string
    {
        return $this->total_submits;
    }

    public function setTotalSubmits(string $total_submits): static
    {
        $this->total_submits = $total_submits;

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

    public function getFormId(): ?Form
    {
        return $this->form_id;
    }

    public function setFormId(?Form $form_id): static
    {
        $this->form_id = $form_id;

        return $this;
    }
}
