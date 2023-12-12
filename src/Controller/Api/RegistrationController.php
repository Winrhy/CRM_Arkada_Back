<?php

namespace App\Controller\Api;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class RegistrationController extends AbstractController
{
    /**
     * Constructor for RegistrationController.
     *
     * @param JWTTokenManagerInterface $jwtManager The JWT token manager service.
     */
    public function __construct(JWTTokenManagerInterface $jwtManager)
    {
        $this->jwtManager = $jwtManager;
    }


    /**
     * Handles the user registration process.
     *
     * Accepts a POST request with user credentials, creates a new User entity, hashes the password,
     * and saves the new user to the database. Returns a JSON response with registration details.
     *
     * @param EntityManagerInterface $em The entity manager interface for database interaction.
     * @param Request $request The HTTP request object, containing user data.
     * @param UserPasswordHasherInterface $passwordHasher The hasher interface for user passwords.
     * @return JsonResponse Returns a JSON response containing a success message and user data.
     */
    #[Route('/register', name: 'app_register', methods: ['POST'])]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $em): JsonResponse
    {
        $decoder = json_decode($request->getContent());

        // Validate JSON and required fields
        if (!$decoder || !isset($decoder->email, $decoder->password, $decoder->firstName, $decoder->lastName)) {
            return $this->json(['message' => 'Invalid data provided'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Check if user with the same email already exists
        $existingUser = $em->getRepository(User::class)->findOneBy(['email' => $decoder->email]);
        if ($existingUser) {
            return $this->json(['message' => 'User with this email already exists'], JsonResponse::HTTP_CONFLICT);
        }

        // Proceed with user creation
        $user = new User();
        $hashedPassword = $passwordHasher->hashPassword($user, $decoder->password);
        $user->setPassword($hashedPassword);
        $user->setEmail($decoder->email);
        $user->setFirstName($decoder->firstName);
        $user->setLastName($decoder->lastName);
        $user->setCreatedAt(new \DateTimeImmutable());

        try {
            $em->persist($user);
            $em->flush();
        } catch (\Exception $e) {
            // Handle any exceptions during the database write operation
            return $this->json(['message' => 'Error occurred while registering user'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json([
            'message' => 'Registration successful',
            'success' => true,
            'userId' => $user->getId(),
        ]);
    }


    /**
     * Retrieves and returns all users.
     *
     * Handles a GET request to fetch all users from the database.
     * Returns a JSON response with the list of users.
     *
     * @param EntityManagerInterface $em The entity manager interface for database interaction.
     * @param Request $request The HTTP request object.
     * @param UserPasswordHasherInterface $passwordHasher The hasher interface for user passwords.
     * @return JsonResponse Returns a JSON response containing the list of all users.
     */
    #[Route('/users', name: 'app_users', methods: ['GET'])]
    public function getAllUsers(EntityManagerInterface $em, Request $request, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {

        $users = $em->getRepository(User::class)->findAll();

        return $this->json([
            'users' => $users,
        ]);
    }

}
