<?php

namespace App\Controller\Api;

use App\DTO\ContactDTO;
use App\Form\Type\ContactType;
use App\Service\ContactService;
use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


#[Route('/contact')]
class ContactController extends AbstractController
{
    private ContactService $contactService;

    /**
     * Constructor for ContactController.
     *
     * @param ContactService $contactService The service for handling contact operations.
     */
    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    /**
     * Create a new contact.
     *
     * @param Request $request The HTTP request object.
     *
     * @return JsonResponse The JSON response.
     */
    #[Route('', name: 'contact_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse {
        $contactDTO = new ContactDTO();
        $form = $this->createForm(ContactType::class, $contactDTO);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $this->contactService->createContact($contactDTO);
            return $this->json($contact, JsonResponse::HTTP_CREATED);
        }

        return $this->json(['errors' => (string) $form->getErrors(true, false)], JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Read a specific contact by ID.
     *
     * @param Contact $contact The contact entity.
     *
     * @return JsonResponse The JSON response.
     */
    #[Route('/{id}', name: 'contact_read', methods: ['GET'])]
    #[ParamConverter('contact', class: Contact::class)]
    public function read(Contact $contact): JsonResponse {
        return $this->json($contact);
    }

    /**
     * Update a specific contact by ID.
     *
     * @param Request $request The HTTP request object.
     * @param Contact $contact The contact entity.
     *
     * @return JsonResponse The JSON response.
     */
    #[Route('/{id}', name: 'contact_update', methods: ['PUT'])]
    #[ParamConverter('contact', class: Contact::class)]
    public function update(Request $request, Contact $contact): JsonResponse {
        $contactDTO = ContactDTO::createFromEntity($contact);
        $form = $this->createForm(ContactType::class, $contactDTO);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isSubmitted() && $form->isValid()) {
            $this->contactService->updateContact($contact, $contactDTO);
            return $this->json($contact);
        }

        return $this->json(['errors' => (string) $form->getErrors(true, false)], JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * Delete a specific contact by ID.
     *
     * @param Contact $contact The contact entity.
     *
     * @return JsonResponse The JSON response.
     */
    #[Route('/{id}', name: 'contact_delete', methods: ['DELETE'])]
    #[ParamConverter('contact', class: Contact::class)]
    public function delete(Contact $contact): JsonResponse {
        $this->contactService->deleteContact($contact);
        return $this->json(['message' => 'Contact deleted successfully']);
    }

    /**
     * List all contacts.
     *
     * @return JsonResponse The JSON response.
     */
    #[Route('', name: 'contact_list', methods: ['GET'])]
    public function list(): JsonResponse {
        $contacts = $this->contactService->getAllContacts();
        return $this->json($contacts);
    }

    /**
     * List all email contacts.
     *
     * @return JsonResponse The JSON response.
     */
    #[Route('/get/emails', name: 'contact_list_email', methods: ['GET'])]
    public function email(): JsonResponse {
        $contacts = $this->contactService->getAllContactEmail();
        return $this->json($contacts);
    }
}
