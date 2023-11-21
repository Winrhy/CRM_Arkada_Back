<?php

namespace App\Entity;

use App\Repository\CtaClicksRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV6 as Uuid;

#[ORM\Entity(repositoryClass: CtaClicksRepository::class)]
class CtaClicks
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $click_date = null;

    #[ORM\Column(length: 255)]
    private ?string $click_ip = null;

    #[ORM\Column(length: 255)]
    private ?string $user_agent = null;

    #[ORM\ManyToOne(inversedBy: 'ctaClicks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cta $cta_id = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getClickDate(): ?\DateTimeImmutable
    {
        return $this->click_date;
    }

    public function setClickDate(\DateTimeImmutable $click_date): static
    {
        $this->click_date = $click_date;

        return $this;
    }

    public function getClickIp(): ?string
    {
        return $this->click_ip;
    }

    public function setClickIp(string $click_ip): static
    {
        $this->click_ip = $click_ip;

        return $this;
    }

    public function getUserAgent(): ?string
    {
        return $this->user_agent;
    }

    public function setUserAgent(string $user_agent): static
    {
        $this->user_agent = $user_agent;

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
