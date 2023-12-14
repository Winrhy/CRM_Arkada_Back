<?php

namespace App\Service;

use App\Entity\Contact;
use App\DTO\ContactDTO;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Service class for handling contact operations.
 */
class ContactService
{
    private EntityManagerInterface $entityManager;
    private ContactRepository $contactRepository;

    /**
     * Constructor for ContactService.
     *
     * @param EntityManagerInterface $entityManager The EntityManager interface.
     * @param ContactRepository $contactRepository The repository for Contact.
     */
    public function __construct(EntityManagerInterface $entityManager, ContactRepository $contactRepository)
    {
        $this->entityManager = $entityManager;
        $this->contactRepository = $contactRepository;
    }

    /**
     * Create a new contact.
     *
     * @param ContactDTO $contactDTO The Data Transfer Object for contact data.
     * @return Contact The created Contact entity.
     */
    public function createContact(ContactDTO $contactDTO): Contact
    {
        $contact = new Contact();
        $contactDTO->mapToEntity($contact);
        $contact->setCreatedAt(new \DateTimeImmutable());
        $contact->setInteractionCount(1);


        $this->entityManager->persist($contact);
        $this->entityManager->flush();

        return $contact;
    }

    /**
     * Update an existing contact.
     *
     * @param Contact $contact The existing Contact entity.
     * @param ContactDTO $contactDTO The Data Transfer Object for new contact data.
     */
    public function updateContact(Contact $contact, ContactDTO $contactDTO): void
    {
        $contactDTO->mapToEntity($contact);
        $this->entityManager->flush();
    }

    /**
     * Delete a contact.
     *
     * @param Contact $contact The Contact entity to be deleted.
     */
    public function deleteContact(Contact $contact): void
    {
        $this->entityManager->remove($contact);
        $this->entityManager->flush();
    }

    /**
     * Get all contacts.
     *
     * @return Contact[] An array of Contact entities.
     */
    public function getAllContacts(): array
    {
        return $this->contactRepository->findAll();
    }


    public function getAllContactEmail() :array
    {
        $contacts = $this->contactRepository->findAll();
        $emailList = [];
        foreach ($contacts as $contact) {
            $emailList[] = [
                'email' => $contact->getEmail(),
                'firstname' => $contact->getFirstname(),
                'lastname' => $contact->getLastname(),
            ];
        }
        return $emailList;
    }
}
