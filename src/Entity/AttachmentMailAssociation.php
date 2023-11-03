<?php

namespace App\Entity;

use App\Repository\AttachmentMailAssociationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV6 as Uuid;


#[ORM\Entity(repositoryClass: AttachmentMailAssociationRepository::class)]
class AttachmentMailAssociation
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\ManyToOne(inversedBy: 'attachmentMailAssociations')]
    private ?Attachment $attachment_id = null;

    #[ORM\ManyToOne(inversedBy: 'attachmentMailAssociations')]
    private ?Mail $mail_id = null;

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

    public function getMailId(): ?Mail
    {
        return $this->mail_id;
    }

    public function setMailId(?Mail $mail_id): static
    {
        $this->mail_id = $mail_id;

        return $this;
    }
}
