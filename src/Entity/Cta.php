<?php

namespace App\Entity;

use App\Repository\CtaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV6 as Uuid;

#[ORM\Entity(repositoryClass: CtaRepository::class)]
class Cta
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(length: 255)]
    private ?string $destination_url = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $modified_at = null;

    #[ORM\ManyToOne(inversedBy: 'ctas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_id = null;

    #[ORM\ManyToOne(inversedBy: 'ctas')]
    private ?CtaTemplate $template_id = null;

    #[ORM\OneToMany(mappedBy: 'cta_id', targetEntity: CtaClicks::class)]
    private Collection $ctaClicks;

    #[ORM\OneToMany(mappedBy: 'cta_id', targetEntity: CtaStats::class)]
    private Collection $ctaStats;

    public function __construct()
    {
        $this->ctaClicks = new ArrayCollection();
        $this->ctaStats = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getDestinationUrl(): ?string
    {
        return $this->destination_url;
    }

    public function setDestinationUrl(string $destination_url): static
    {
        $this->destination_url = $destination_url;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeImmutable
    {
        return $this->modified_at;
    }

    public function setModifiedAt(?\DateTimeImmutable $modified_at): static
    {
        $this->modified_at = $modified_at;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getTemplateId(): ?CtaTemplate
    {
        return $this->template_id;
    }

    public function setTemplateId(?CtaTemplate $template_id): static
    {
        $this->template_id = $template_id;

        return $this;
    }

    /**
     * @return Collection<int, CtaClicks>
     */
    public function getCtaClicks(): Collection
    {
        return $this->ctaClicks;
    }

    public function addCtaClick(CtaClicks $ctaClick): static
    {
        if (!$this->ctaClicks->contains($ctaClick)) {
            $this->ctaClicks->add($ctaClick);
            $ctaClick->setCtaId($this);
        }

        return $this;
    }

    public function removeCtaClick(CtaClicks $ctaClick): static
    {
        if ($this->ctaClicks->removeElement($ctaClick)) {
            // set the owning side to null (unless already changed)
            if ($ctaClick->getCtaId() === $this) {
                $ctaClick->setCtaId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CtaStats>
     */
    public function getCtaStats(): Collection
    {
        return $this->ctaStats;
    }

    public function addCtaStat(CtaStats $ctaStat): static
    {
        if (!$this->ctaStats->contains($ctaStat)) {
            $this->ctaStats->add($ctaStat);
            $ctaStat->setCtaId($this);
        }

        return $this;
    }

    public function removeCtaStat(CtaStats $ctaStat): static
    {
        if ($this->ctaStats->removeElement($ctaStat)) {
            // set the owning side to null (unless already changed)
            if ($ctaStat->getCtaId() === $this) {
                $ctaStat->setCtaId(null);
            }
        }

        return $this;
    }
}
