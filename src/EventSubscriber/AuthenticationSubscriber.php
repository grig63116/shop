<?php

namespace App\EventSubscriber;

use App\Service\CartServiceInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;
use App\Entity\User;

/**
 * Class AuthenticationSubscriber
 * @package App\EventSubscriber
 */
class AuthenticationSubscriber implements EventSubscriberInterface
{
    /**
     * @var CartServiceInterface
     */
    protected $cartService;

    public function __construct(
        CartServiceInterface $cartService
    )
    {
        $this->cartService = $cartService;
    }

    /**
     * @return string[]
     */
    public static function getSubscribedEvents()
    {
        return [
            SecurityEvents::INTERACTIVE_LOGIN => 'onInteractiveLogin',
        ];
    }

    /**
     * @param InteractiveLoginEvent $event
     */
    public function onInteractiveLogin(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();
        $request = $event->getRequest();
        if ($user instanceof User && $request->hasSession()) {
            $old = $request->hasPreviousSession() ? $request->cookies->get($request->getSession()->getName()) : null;
            $new = $request->getSession()->getId();
            $userId = $user->getId();
            $this->cartService->migrate(oldSessionId: $old, newSessionId: $new, userId: $userId);
        }
    }
}
