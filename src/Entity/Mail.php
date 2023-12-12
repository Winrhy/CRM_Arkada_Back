<?php

namespace App\Entity;

use App\Repository\MailRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV7 as Uuid;
use Symfony\Component\Routing\Annotation\Route;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\MailingController;

#[ORM\Entity(repositoryClass: MailRepository::class)]
#[ApiResource(
    collectionOperations: [
        'create_email' => [
            'method' => 'POST',
            'path' => '/mail/create',
            'controller' => MailingController::class,
            'description' => 'Create a new email',
            // ... other settings like serialization groups
        ],
        'send_template' => [
            'method' => 'POST',
            'path' => '/mail/send-template/{template_id}',
            'controller' => MailingController::class,
            // ... other settings
        ],
        // ... other operations
    ],
    itemOperations: [
        'get' => [
            'method' => 'GET',
            'path' => '/mail/{id}',
            // ... other settings
        ],
        'single_email' => [
            'method' => 'GET',
            'path' => '/mail/single',
            'controller' => MailingController::class,
            // ... other settings
        ],
        // ... other item operations
    ]
)]
class Mail{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    private ?string $subject = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $body = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $timestamp = null;

    #[ORM\Column(length: 255)]
    private ?string $sender_mail = null;

    #[ORM\Column(length: 255)]
    private ?string $receiver = null;

    #[ORM\Column]
    private ?bool $read = null;

    #[ORM\Column]
    private ?int $dead_pixel_id = null;

    #[ORM\ManyToOne(inversedBy: 'mails')]
    private ?Contact $contact_id = null;

    #[ORM\ManyToOne(inversedBy: 'mails')]
    private ?MailTemplate $template_id = null;

    #[ORM\ManyToOne(inversedBy: 'mails')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_id = null;

    #[ORM\OneToMany(mappedBy: 'mail_id', targetEntity: AttachmentMailAssociation::class)]
    private Collection $attachmentMailAssociations;

    public function __construct()
    {
        $this->attachmentMailAssociations = new ArrayCollection();
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

    public function getTimestamp(): ?\DateTimeImmutable
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTimeImmutable $timestamp): static
    {
        $this->timestamp = $timestamp;

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

    public function getReceiver(): ?string
    {
        return $this->receiver;
    }

    public function setReceiver(string $receiver): static
    {
        $this->receiver = $receiver;

        return $this;
    }

    public function isRead(): ?bool
    {
        return $this->read;
    }

    public function setRead(bool $read): static
    {
        $this->read = $read;

        return $this;
    }

    public function getDeadPixelId(): ?int
    {
        return $this->dead_pixel_id;
    }

    public function setDeadPixelId(int $dead_pixel_id): static
    {
        $this->dead_pixel_id = $dead_pixel_id;

        return $this;
    }

    public function getContactId(): ?Contact
    {
        return $this->contact_id;
    }

    public function setContactId(?Contact $contact_id): static
    {
        $this->contact_id = $contact_id;

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
            $attachmentMailAssociation->setMailId($this);
        }

        return $this;
    }

    public function removeAttachmentMailAssociation(AttachmentMailAssociation $attachmentMailAssociation): static
    {
        if ($this->attachmentMailAssociations->removeElement($attachmentMailAssociation)) {
            // set the owning side to null (unless already changed)
            if ($attachmentMailAssociation->getMailId() === $this) {
                $attachmentMailAssociation->setMailId(null);
            }
        }

        return $this;
    }
}
