<?php

namespace App\DTO;

use DateTimeInterface;
use App\Entity\Contact;

/**
 * Data Transfer Object for Contact data.
 */
class ContactDTO
{
    public ?Uuid $id = null;
    public ?string $firstName = null;
    public ?string $lastName = null;
    public ?DateTimeInterface $birthdate = null;
    public ?string $email = null;
    public ?string $address = null;
    public ?string $country = null;
    public ?string $city = null;
    public ?string $postalCode = null;
    public ?bool $marketing = null;
    public ?string $type = null;
    public ?string $status = null;
    public ?DateTimeInterface $createdAt = null;
    public ?DateTimeInterface $modifiedAt = null;
    public ?DateTimeInterface $lastInteraction = null;
    public ?string $interactionCount = null;
    public ?string $comment = null;
    public ?string $source = null;
    public ?string $language = null;
    public ?Uuid $userId = null;

    public function __construct($contact = null)
    {
        if ($contact) {
            $this->id = $contact->getId();
            $this->firstName = $contact->getFirstName();
            $this->lastName = $contact->getLastName();
            $this->birthdate = $contact->getBirthdate();
            $this->email = $contact->getEmail();
            $this->address = $contact->getAddress();
            $this->country = $contact->getCountry();
            $this->city = $contact->getCity();
            $this->postalCode = $contact->getPostalCode();
            $this->marketing = $contact->isMarketing();
            $this->type = $contact->getType();
            $this->status = $contact->getStatus();
            $this->createdAt = $contact->getCreatedAt();
            $this->modifiedAt = $contact->getModifiedAt();
            $this->lastInteraction = $contact->getLastInteraction();
            $this->interactionCount = $contact->getInteractionCount();
            $this->comment = $contact->getComment();
            $this->source = $contact->getSource();
            $this->language = $contact->getLanguage();
            $this->userId = $contact->getUserId() ? $contact->getUserId()->getId() : null;
        }
    }

    public static function createFromEntity($contact): self
    {
        return new self($contact);
    }

    /**
     * Maps the DTO properties back to a Contact entity.
     *
     * @param Contact $contact The contact entity to be updated.
     * @return Contact The updated contact entity.
     */
    public function mapToEntity(Contact $contact): Contact
    {
        $contact->setFirstName($this->firstName);
        $contact->setLastName($this->lastName);
        $contact->setBirthdate($this->birthdate);
        $contact->setEmail($this->email);
        $contact->setAddress($this->address);
        $contact->setCountry($this->country);
        $contact->setCity($this->city);
        $contact->setPostalCode($this->postalCode);
        $contact->setMarketing($this->marketing);
        $contact->setType($this->type);
        $contact->setStatus($this->status);
        $contact->setModifiedAt($this->modifiedAt);
        $contact->setLastInteraction($this->lastInteraction);
        $contact->setComment($this->comment);
        $contact->setSource($this->source);
        $contact->setLanguage($this->language);
        if ($this->userId) {
            $contact->setUserId($this->userId);
        }
        if ($this->interactionCount !== null) {
            $contact->setInteractionCount($this->interactionCount);
        }


        return $contact;
    }
}
