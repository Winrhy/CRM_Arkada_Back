<?php

namespace App\Entity;

use App\Repository\AttachmentTemplateMailAssociationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV6 as Uuid;


#[ORM\Entity(repositoryClass: AttachmentTemplateMailAssociationRepository::class)]
class AttachmentTemplateMailAssociation
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\ManyToOne(inversedBy: 'attachmentTemplateMailAssociations')]
    private ?Attachment $attachment_id = null;

    #[ORM\ManyToOne(inversedBy: 'attachmentTemplateMailAssociations')]
    private ?MailTemplate $template_id = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getAttachmentId(): ?Attachment
    {
        return $this->attachment_id;
    }

    public function setAttachmentId(?Attachment $attachment_id): static
    {
        $this->attachment_id = $attachment_id;

        return $this;
    }

    public function getTemplateId(): ?MailTemplate
    {
        return $this->template_id;
    }

    public function setTemplateId(?MailTemplate $template_id): static
    {
        $this->template_id = $template_id;

        return $this;
    }
}
