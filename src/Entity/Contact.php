<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\UuidV7 as Uuid;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['get_user'])]
    private ?string $first_name = null;

    #[ORM\Column(length: 255)]
    private ?string $last_name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthdate = null;

    #[ORM\Column(length: 255)]
    #[Groups(['get_user'])]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    private ?string $country = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    private ?string $postal_code = null;

    #[ORM\Column]
    private ?bool $marketing = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $modified_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $last_interaction = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $interaction_count = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $comment = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $source = null;

    #[ORM\Column(length: 255)]
    private ?string $language = null;

    #[ORM\ManyToOne(inversedBy: 'contacts')]
    private ?User $user_id = null;

    #[ORM\OneToMany(mappedBy: 'contact_id', targetEntity: ContactCompanyAssociation::class)]
    private Collection $contactCompanyAssociations;

    #[ORM\OneToMany(mappedBy: 'contact_id', targetEntity: Interaction::class)]
    private Collection $interactions;

    #[ORM\OneToMany(mappedBy: 'contact_id', targetEntity: SegmentContactAssociation::class)]
    private Collection $segmentContactAssociations;

    #[ORM\OneToMany(mappedBy: 'contact_id', targetEntity: Mail::class)]
    private Collection $mails;

    public function __construct()
    {
        $this->contactCompanyAssociations = new ArrayCollection();
        $this->interactions = new ArrayCollection();
        $this->segmentContactAssociations = new ArrayCollection();
        $this->mails = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): static
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postal_code;
    }

    public function setPostalCode(string $postal_code): static
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    public function isMarketing(): ?bool
    {
        return $this->marketing;
    }

    public function setMarketing(bool $marketing): static
    {
        $this->marketing = $marketing;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

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

    public function getLastInteraction(): ?\DateTimeImmutable
    {
        return $this->last_interaction;
    }

    public function setLastInteraction(?\DateTimeImmutable $last_interaction): static
    {
        $this->last_interaction = $last_interaction;

        return $this;
    }

    public function getInteractionCount(): ?string
    {
        return $this->interaction_count;
    }

    public function setInteractionCount(string $interaction_count): static
    {
        $this->interaction_count = $interaction_count;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(?string $source): static
    {
        $this->source = $source;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): static
    {
        $this->language = $language;

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
     * @return Collection<int, ContactCompanyAssociation>
     */
    public function getContactCompanyAssociations(): Collection
    {
        return $this->contactCompanyAssociations;
    }

    public function addContactCompanyAssociation(ContactCompanyAssociation $contactCompanyAssociation): static
    {
        if (!$this->contactCompanyAssociations->contains($contactCompanyAssociation)) {
            $this->contactCompanyAssociations->add($contactCompanyAssociation);
            $contactCompanyAssociation->setContactId($this);
        }

        return $this;
    }

    public function removeContactCompanyAssociation(ContactCompanyAssociation $contactCompanyAssociation): static
    {
        if ($this->contactCompanyAssociations->removeElement($contactCompanyAssociation)) {
            // set the owning side to null (unless already changed)
            if ($contactCompanyAssociation->getContactId() === $this) {
                $contactCompanyAssociation->setContactId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Interaction>
     */
    public function getInteractions(): Collection
    {
        return $this->interactions;
    }

    public function addInteraction(Interaction $interaction): static
    {
        if (!$this->interactions->contains($interaction)) {
            $this->interactions->add($interaction);
            $interaction->setContactId($this);
        }

        return $this;
    }

    public function removeInteraction(Interaction $interaction): static
    {
        if ($this->interactions->removeElement($interaction)) {
            // set the owning side to null (unless already changed)
            if ($interaction->getContactId() === $this) {
                $interaction->setContactId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SegmentContactAssociation>
     */
    public function getSegmentContactAssociations(): Collection
    {
        return $this->segmentContactAssociations;
    }

    public function addSegmentContactAssociation(SegmentContactAssociation $segmentContactAssociation): static
    {
        if (!$this->segmentContactAssociations->contains($segmentContactAssociation)) {
            $this->segmentContactAssociations->add($segmentContactAssociation);
            $segmentContactAssociation->setContactId($this);
        }

        return $this;
    }

    public function removeSegmentContactAssociation(SegmentContactAssociation $segmentContactAssociation): static
    {
        if ($this->segmentContactAssociations->removeElement($segmentContactAssociation)) {
            // set the owning side to null (unless already changed)
            if ($segmentContactAssociation->getContactId() === $this) {
                $segmentContactAssociation->setContactId(null);
            }
        }

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
            $mail->setContactId($this);
        }

        return $this;
    }

    public function removeMail(Mail $mail): static
    {
        if ($this->mails->removeElement($mail)) {
            // set the owning side to null (unless already changed)
            if ($mail->getContactId() === $this) {
                $mail->setContactId(null);
            }
        }

        return $this;
    }
}
