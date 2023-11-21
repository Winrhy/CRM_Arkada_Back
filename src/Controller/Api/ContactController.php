<?php

namespace App\Controller\Api;

use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Uid\UuidV6 as Uuid;


#[Route('/contact')]
class ContactController extends AbstractController
{
    /**
     * Create a new contact.
     *
     * @param Request                $request
     * @param EntityManagerInterface $entityManager
     * @param SerializerInterface    $serializer
     * @param ValidatorInterface     $validator
     *
     * @return JsonResponse
     *
     * @Route('', name: 'contact_create', methods: ['POST'])
     */
    #[Route('', name: 'contact_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse {
        // Get JSON data from the request
        $contactData = $request->getContent();

        try {
            // Deserialize the data into a Contact object
            $contact = $serializer->deserialize($contactData, Contact::class, 'json');
        } catch (\Exception $e) {
            // Handle deserialization errors
            return $this->json(['error' => 'Invalid JSON: ' . $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Validate the Contact object
        $errors = $validator->validate($contact);
        if (count($errors) > 0) {
            // If there are validation errors, return them
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }
            return $this->json(['errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Persist the Contact object in the database
        $createdAt = new \DateTimeImmutable();
        $contact->setCreatedAt($createdAt);
        $entityManager->persist($contact);
        $entityManager->flush();

        // Return a success response
        return $this->json([
            'message' => 'Contact created successfully',
            'contact' => $contact
        ], JsonResponse::HTTP_CREATED);
    }


    /**
     * Read a specific contact by ID.
     *
     * Retrieves the details of a specific contact by its ID.
     *
     * @Route("/contact/{id}", name="contact_read", methods={"GET"})
     *
     * @param Contact $contact The contact entity retrieved by its ID.
     *
     * @return JsonResponse A JSON response containing the contact details.
     */
    #[Route('/{id}', name: 'contact_by_id', methods: ['GET'])]
    public function read(Contact $contact): JsonResponse
    {
        // Vous avez déjà récupéré le contact par son ID grâce à l'injection de dépendance Contact $contact.
        // Vous pouvez maintenant renvoyer les détails du contact dans une réponse JSON.

        return $this->json([
            'contact' => $contact,
        ]);
    }


    /*// Update a specific contact
    // PUT /contact/{id}
    // This method updates an existing contact with the data sent in the request body.
    #[Route('/{id}', name: 'contact_update', methods: ['PUT'])]
    public function update(Request $request, Contact $contact): Response
    {
        // Update the contact with the request data
    */

    /**
     * Delete a specific contact by ID.
     *
     * Deletes a specific contact by its ID.
     *
     * @Route("/contact/{id}", name="contact_delete", methods={"DELETE"})
     *
     * @param Contact $contact The contact entity to delete.
     *
     * @return JsonResponse A JSON response indicating the result of the deletion.
     */
    #[Route('/{id}', name: 'contact_delete', methods: ['DELETE'])]
    public function delete(Contact $contact, EntityManagerInterface $entityManager): JsonResponse
    {
        // Check if the contact exists
        if (!$contact) {
            return $this->json(['error' => 'Contact not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        // Remove the contact from the database
        $entityManager->remove($contact);
        $entityManager->flush();

        return $this->json(['message' => 'Contact deleted successfully'], JsonResponse::HTTP_OK);
    }


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
