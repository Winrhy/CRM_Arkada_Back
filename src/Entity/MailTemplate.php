<?php

namespace App\Entity;

use App\Repository\MailTemplateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV7 as Uuid;

#[ORM\Entity(repositoryClass: MailTemplateRepository::class)]
class MailTemplate
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    private ?string $subject = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $body = null;

    #[ORM\Column(length: 255)]
    private ?string $sender_mail = null;

    #[ORM\Lazy]
    #[ORM\ManyToOne(inversedBy: 'mailTemplates')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_id = null;

    #[ORM\OneToMany(mappedBy: 'template_id', targetEntity: Mail::class)]
    private Collection $mails;

    #[ORM\OneToMany(mappedBy: 'template_id', targetEntity: AttachmentTemplateMailAssociation::class)]
    private Collection $attachmentTemplateMailAssociations;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $template_name = null;

    public function __construct()
    {
        $this->mails = new ArrayCollection();
        $this->attachmentTemplateMailAssociations = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): static
    {
        $this->subject = $subject;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): static
    {
        $this->body = $body;

        return $this;
    }

    public function getSenderMail(): ?string
    {
        return $this->sender_mail;
    }

    public function setSenderMail(string $sender_mail): static
    {
        $this->sender_mail = $sender_mail;

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
     * @return Collection<int, Mail>
     */
    public function getMails(): Collection
    {
        return $this->mails;
    }

    public function addMail(Mail $mail): static
    {
        if (!$this->mails->contains($mail)) {
            $this->mails->add($mail);
            $mail->setTemplateId($this);
        }

        return $this;
    }

    public function removeMail(Mail $mail): static
    {
        if ($this->mails->removeElement($mail)) {
            // set the owning side to null (unless already changed)
            if ($mail->getTemplateId() === $this) {
                $mail->setTemplateId(null);
            }
        }

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
            $attachmentTemplateMailAssociation->setTemplateId($this);
        }

        return $this;
    }

    public function removeAttachmentTemplateMailAssociation(AttachmentTemplateMailAssociation $attachmentTemplateMailAssociation): static
    {
        if ($this->attachmentTemplateMailAssociations->removeElement($attachmentTemplateMailAssociation)) {
            // set the owning side to null (unless already changed)
            if ($attachmentTemplateMailAssociation->getTemplateId() === $this) {
                $attachmentTemplateMailAssociation->setTemplateId(null);
            }
        }

        return $this;
    }

    public function getTemplateName(): ?string
    {
        return $this->template_name;
    }

    public function setTemplateName(?string $template_name): static
    {
        $this->template_name = $template_name;

        return $this;
    }
}
