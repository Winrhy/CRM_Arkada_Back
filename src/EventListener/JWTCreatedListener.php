<?php

namespace App\EventListener;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;

class JWTCreatedListener
{

    private $requestStack;
    private $em;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack, EntityManagerInterface $em)
    {
        $this->requestStack = $requestStack;
        $this->em = $em;
    }


    public function onJWTCreated(JWTCreatedEvent $event)
    {

        $request = $this->requestStack->getCurrentRequest();

        $userEmail = $event->getUser()->getUserIdentifier(); // Get the user from the event

        $user = $this->em->getRepository(User::class)->findOneBy(["email" => $userEmail]);

        $payload = $event->getData();

        // Modify the JWT payload here
        $payload['uuid'] = $user->getId(); // Add custom data

        $event->setData($payload);
    }
}