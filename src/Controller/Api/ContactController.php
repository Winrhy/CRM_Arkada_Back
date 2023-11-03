<?php

namespace App\Controller\Api;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contact')]
class ContactController extends AbstractController
{
    /*// Create a new contact
    // POST /contact
    // This method handles the creation of a new contact. It expects the contact data to be sent in the request body.
    #[Route('/', name: 'contact_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        // Handle the request and create a new Contact entity
    }

    // Read a specific contact by ID
    // GET /contact/{id}
    // This method retrieves the details of a specific contact by its ID.
    #[Route('/{id}', name: 'contact_read', methods: ['GET'])]
    public function read(Contact $contact): JsonResponse
    {
        // Return the contact data
    }

    // Update a specific contact
    // PUT /contact/{id}
    // This method updates an existing contact with the data sent in the request body.
    #[Route('/{id}', name: 'contact_update', methods: ['PUT'])]
    public function update(Request $request, Contact $contact): Response
    {
        // Update the contact with the request data
    }

    // Delete a specific contact
    // DELETE /contact/{id}
    // This method deletes a specific contact by its ID.
    #[Route('/{id}', name: 'contact_delete', methods: ['DELETE'])]
    public function delete(Contact $contact): JsonResponse
    {
        // Delete the contact
    }*/

    // List all contacts
    // GET /contact/list
    // This method returns a list of all contacts.
    #[Route('/list', name: 'contact_list', methods: ['GET'])]
    public function list(ContactRepository $repository): JsonResponse
    {
        $contacts = $repository->findAll();
        $contactData = [];
    
        foreach ($contacts as $contact) {
            $contactData[] = [
                'id' => $contact->getId(),
                'first_name' => $contact->getFirstName(),
                'last_name' => $contact->getLastName(),
                'birthdate' => $contact->getBirthdate() ? $contact->getBirthdate()->format('Y-m-d') : null,
                'email' => $contact->getEmail(),
                'address' => $contact->getAddress(),
                'country' => $contact->getCountry(),
                'city' => $contact->getCity(),
                'postal_code' => $contact->getPostalCode(),
                'marketing' => $contact->isMarketing(),
                'type' => $contact->getType(),
                'status' => $contact->getStatus(),
                'created_at' => $contact->getCreatedAt() ? $contact->getCreatedAt()->format('c') : null,
                'modified_at' => $contact->getModifiedAt() ? $contact->getModifiedAt()->format('c') : null,
                'last_interaction' => $contact->getLastInteraction() ? $contact->getLastInteraction()->format('c') : null,
                'interaction_count' => $contact->getInteractionCount(),
                'comment' => $contact->getComment(),
                'source' => $contact->getSource(),
                'language' => $contact->getLanguage(),
                'user_id' => $contact->getUserId() ? $contact->getUserId()->getId() : null,
            ];
        }
    
        return $this->json($contactData);
    }    
}
