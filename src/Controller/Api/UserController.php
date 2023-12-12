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
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/users', name: 'app_users', methods: ['GET'])]
    public function getAllUsers(EntityManagerInterface $em): JsonResponse
    {

        $users = $em->getRepository(User::class)->findAll();

        return $this->json([
            'users' => $users,
        ]);
    }

    #[Route('/user', name: 'app_user', methods: ['POST'])]
    public function getOneUserById(EntityManagerInterface $em, Request $request): JsonResponse
    {
        $decoder = json_decode($request->getContent());
        $user = $em->getRepository(User::class)->findBy(["email" => $decoder->email]);

        return $this->json([
            'user' => $user,
        ]);
    }
}
