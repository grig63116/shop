<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\EntityManagerInterface;

class AuthenticationSubscrber implements EventSubscriberInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;


    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(
        EntityManagerInterface $em
    )
    {
        $this->em = $em;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            SecurityEvents::INTERACTIVE_LOGIN => ['onSecurityInteractiveLogin', 0],
        ];
    }

    /**
     * @param InteractiveLoginEvent $event
     */
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
//        $user = $event->getAuthenticationToken()->getUser();
//
//        if ($user instanceof User) {
//            $user->setLastLogin(new \DateTime());
//            $user->setConfirmationToken(null);
//            $user->setPasswordRequestedAt(null);
//            $this->em->persist($user);
//            $this->em->flush();
//        }
    }
}
