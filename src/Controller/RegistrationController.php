<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
class RegistrationController extends AbstractController
{

    public function __construct(JWTTokenManagerInterface $jwtManager)
    {
        $this->jwtManager = $jwtManager;
    }

    #[Route('/register', name: 'app_register', methods: ['POST'])]
    public function register(EntityManagerInterface $em, Request $request, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {

        $decoder = json_decode($request->getContent());
        $email = $decoder->email;
        $plainPassword = $decoder->password;
        $firstName = $decoder->firstName;
        $lastName = $decoder->lastName;
        $now = new \DateTimeImmutable('now');
        $user = new User();
        $hashPassword = $passwordHasher->hashPassword($user,$plainPassword);
        $user->setPassword($hashPassword);
        $user->setEmail($email);
//        $user->setUsername($email);
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setCreatedAt($now);
        $em->persist($user);
        $em->flush();

        return $this->json([
            'message' => 'Registration for the Arkada CRM successful',
            'success' => true,
            'user' => $user,
        ]);
    }

    #[Route('/users', name: 'app_users', methods: ['GET'])]
    public function getAllUsers(EntityManagerInterface $em, Request $request, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {

        $users = $em->getRepository(User::class)->findAll();

        return $this->json([
            'users' => $users,
        ]);
    }

}
