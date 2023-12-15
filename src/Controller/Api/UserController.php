<?php

namespace App\Controller\Api;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class UserController extends AbstractController
{

    #[Route('/users', name: 'app_users', methods: ['GET'])]
    public function getAllUsers(EntityManagerInterface $em): JsonResponse
    {

        $users = $em->getRepository(User::class)->findAll();

        return $this->json([
            'users' => $users,
        ]);
    }

    #[Route('/user/{id}', name: 'app_user', methods: ['GET'])]
    public function getOneUserById($id,EntityManagerInterface $em): JsonResponse
    {

        $userDatabase = $em->getRepository(User::class)->find($id);

        $userWeb = new User();
        $userWeb->setFirstName($userDatabase->getFirstName());
        $userWeb->setLastName($userDatabase->getLastName());
        $userWeb->setEmail($userDatabase->getEmail());
        $userWeb->setCreatedAt($userDatabase->getCreatedAt());

        return $this->json([
            'user' => $userWeb,
        ]);
    }

    #[Route('/update-token-user', name: 'app_update_user_token', methods: ['POST'])]
    public function updateUserToken(EntityManagerInterface $em, Request $request): JsonResponse
    {

        $decoder = json_decode($request->getContent());

        $userDatabase = $em->getRepository(User::class)->findOneBy(['email' => $decoder->email]);

        $userDatabase->setJwtToken($decoder->token);

        try {
            $em->persist($userDatabase);
            $em->flush();
        } catch (\Exception $e) {
            return $this->json(['message' => 'Error occurred while updating user'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json([
            'message' => 'User correctement modifié',
        ]);
    }

    #[Route('/update-password-user', name: 'app_update_user_password', methods: ['POST'])]
    public function updateUserPassword(EntityManagerInterface $em, Request $request, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {

        $decoder = json_decode($request->getContent());
        $userDatabase = $em->getRepository(User::class)->findOneBy(['jwt_token' => $decoder->token]);
        if ($userDatabase){
            $hashPassword = $passwordHasher->hashPassword($userDatabase,$decoder->password);
            $userDatabase->setPassword($hashPassword);
            try {
                $em->persist($userDatabase);
                $em->flush();
            } catch (\Exception $e) {
                return $this->json(['message' => 'Error occurred while updating user'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            return $this->json(['message' => 'Error occurred while updating user'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json([
            'message' => 'User correctement modifié',
        ]);
    }
}
