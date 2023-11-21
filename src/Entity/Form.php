<?php

namespace App\Entity;

use App\Repository\FormRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV6 as Uuid;

#[ORM\Entity(repositoryClass: FormRepository::class)]
class Form
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $crated_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $modified_at = null;

    #[ORM\ManyToOne(inversedBy: 'forms')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_id = null;

    #[ORM\ManyToOne(inversedBy: 'forms')]
    private ?FormTemplate $template_id = null;

    #[ORM\OneToMany(mappedBy: 'form_id', targetEntity: FormStats::class)]
    private Collection $formStats;

    #[ORM\OneToMany(mappedBy: 'form_id', targetEntity: FormSubmits::class)]
    private Collection $formSubmits;

    public function __construct()
    {
        $this->formStats = new ArrayCollection();
        $this->formSubmits = new ArrayCollection();
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

    public function getCratedAt(): ?\DateTimeImmutable
    {
        return $this->crated_at;
    }

    public function setCratedAt(\DateTimeImmutable $crated_at): static
    {
        $this->crated_at = $crated_at;

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

    public function getTemplateId(): ?FormTemplate
    {
        return $this->template_id;
    }

    public function setTemplateId(?FormTemplate $template_id): static
    {
        $this->template_id = $template_id;

        return $this;
    }

    /**
     * @return Collection<int, FormStats>
     */
    public function getFormStats(): Collection
    {
        return $this->formStats;
    }

    public function addFormStat(FormStats $formStat): static
    {
        if (!$this->formStats->contains($formStat)) {
            $this->formStats->add($formStat);
            $formStat->setFormId($this);
        }

        return $this;
    }

    public function removeFormStat(FormStats $formStat): static
    {
        if ($this->formStats->removeElement($formStat)) {
            // set the owning side to null (unless already changed)
            if ($formStat->getFormId() === $this) {
                $formStat->setFormId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FormSubmits>
     */
    public function getFormSubmits(): Collection
    {
        return $this->formSubmits;
    }

    public function addFormSubmit(FormSubmits $formSubmit): static
    {
        if (!$this->formSubmits->contains($formSubmit)) {
            $this->formSubmits->add($formSubmit);
            $formSubmit->setFormId($this);
        }

        return $this;
    }

    public function removeFormSubmit(FormSubmits $formSubmit): static
    {
        if ($this->formSubmits->removeElement($formSubmit)) {
            // set the owning side to null (unless already changed)
            if ($formSubmit->getFormId() === $this) {
                $formSubmit->setFormId(null);
            }
        }

        return $this;
    }
}
