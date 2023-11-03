<?php

namespace App\Entity;

use App\Repository\AttachmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV6 as Uuid;


#[ORM\Entity(repositoryClass: AttachmentRepository::class)]
class Attachment
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    private ?string $file_name = null;

    #[ORM\Column(length: 255)]
    private ?string $path = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $size = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $upload_date = null;

    #[ORM\ManyToOne(inversedBy: 'attachments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_id = null;

    #[ORM\OneToMany(mappedBy: 'attachment_id', targetEntity: AttachmentTemplateMailAssociation::class)]
    private Collection $attachmentTemplateMailAssociations;

    #[ORM\OneToMany(mappedBy: 'attachment_id', targetEntity: AttachmentMailAssociation::class)]
    private Collection $attachmentMailAssociations;

    public function __construct()
    {
        $this->attachmentTemplateMailAssociations = new ArrayCollection();
        $this->attachmentMailAssociations = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getFileName(): ?string
    {
        return $this->file_name;
    }

    public function setFileName(string $file_name): static
    {
        $this->file_name = $file_name;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): static
    {
        $this->path = $path;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getUploadDate(): ?\DateTimeImmutable
    {
        return $this->upload_date;
    }

    public function setUploadDate(\DateTimeImmutable $upload_date): static
    {
        $this->upload_date = $upload_date;

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

    /**
     * @return Collection<int, AttachmentTemplateMailAssociation>
     */
    public function getAttachmentTemplateMailAssociations(): Collection
    {
        return $this->attachmentTemplateMailAssociations;
    }

    public function addAttachmentTemplateMailAssociation(AttachmentTemplateMailAssociation $attachmentTemplateMailAssociation): static
    {
        if (!$this->attachmentTemplateMailAssociations->contains($attachmentTemplateMailAssociation)) {
            $this->attachmentTemplateMailAssociations->add($attachmentTemplateMailAssociation);
            $attachmentTemplateMailAssociation->setAttachmentId($this);
        }

        return $this;
    }

    public function removeAttachmentTemplateMailAssociation(AttachmentTemplateMailAssociation $attachmentTemplateMailAssociation): static
    {
        if ($this->attachmentTemplateMailAssociations->removeElement($attachmentTemplateMailAssociation)) {
            // set the owning side to null (unless already changed)
            if ($attachmentTemplateMailAssociation->getAttachmentId() === $this) {
                $attachmentTemplateMailAssociation->setAttachmentId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AttachmentMailAssociation>
     */
    public function getAttachmentMailAssociations(): Collection
    {
        return $this->attachmentMailAssociations;
    }

    public function addAttachmentMailAssociation(AttachmentMailAssociation $attachmentMailAssociation): static
    {
        if (!$this->attachmentMailAssociations->contains($attachmentMailAssociation)) {
            $this->attachmentMailAssociations->add($attachmentMailAssociation);
            $attachmentMailAssociation->setAttachmentId($this);
        }

        return $this;
    }

    public function removeAttachmentMailAssociation(AttachmentMailAssociation $attachmentMailAssociation): static
    {
        if ($this->attachmentMailAssociations->removeElement($attachmentMailAssociation)) {
            // set the owning side to null (unless already changed)
            if ($attachmentMailAssociation->getAttachmentId() === $this) {
                $attachmentMailAssociation->setAttachmentId(null);
            }
        }

        return $this;
    }
}
