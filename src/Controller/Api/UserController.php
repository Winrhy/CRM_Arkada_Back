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
}
