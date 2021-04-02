<?php

namespace App\EventSubscriber;

use App\Component\Controller\ControllerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class ControllerSubscriber
 * @package App\EventSubscriber
 */
class ControllerSubscriber implements EventSubscriberInterface
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;
    /**
     * @var ParameterBagInterface
     */
    private $params;

    /**
     * @var UrlGeneratorInterface
     */
    private $router;

    /**
     * ControllerSubscriber constructor.
     * @param TokenStorageInterface $tokenStorage
     * @param ParameterBagInterface $params
     * @param UrlGeneratorInterface $router
     */
    public function __construct(TokenStorageInterface $tokenStorage, ParameterBagInterface $params, UrlGeneratorInterface $router)
    {
        $this->tokenStorage = $tokenStorage;
        $this->params = $params;
        $this->router = $router;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => ['onKernelController', 0],
        ];
    }

    /**
     * @param ControllerEvent $event
     */
    public function onKernelController(ControllerEvent $event)
    {
        $ctrl = $event->getController();

        /*
         * $controller passed can be either a class or a Closure.
         * This is not usual in Symfony but it may happen.
         * If it is a class, it comes in array format
         */
        if (!is_array($ctrl)) {
            return;
        }

        $controller = $ctrl[0];
        $action = $ctrl[1];

        if ($controller instanceof ControllerInterface) {
            if ('Action' != substr($action, -6)) {
                throw new AccessDeniedHttpException('Action "' . get_class($controller) . '::' . $action . '" not found failure.');
            }

            $controllerName = $this->getControllerName($controller);
            $actionName = $this->getActionName($action);

            $controllerNameFormatted = $this->formatName($controllerName);
            $actionNameFormatted = $this->formatName($actionName);

            $controller->setTemplate($controllerNameFormatted . '/' . $actionNameFormatted . '.twig');

            $controller->assign([
                'Controller' => $controllerName,
                'Action' => $actionName,
            ]);

            if (method_exists($controller, 'preDispatch')) {
                call_user_func_array([$controller, 'preDispatch'], []);
            }
        }
    }

    /**
     * @param $class
     * @return string
     */
    private function getControllerName($class)
    {
        $classParts = explode('\\', get_class($class));
        return lcfirst(end($classParts));
    }

    /**
     * @param $action
     * @return string
     */
    private function getActionName($action)
    {
        return lcfirst(substr($action, 0, -6));
    }

    /**
     * @param $name
     * @return string
     */
    private function formatName($name)
    {
        return trim(strtolower(preg_replace('#[A-Z]#', '_$0', $name)), '_');
    }

    /**
     * @param $controller
     * @param $action
     * @return bool
     */
    private function checkFrozenAccess($controller, $action)
    {
        $frozen_allowed_actions = $this->params->get('allowed_actions');

        if (!isset($frozen_allowed_actions[$controller])) {
            return false;
        }
        if (is_array($frozen_allowed_actions[$controller]) && in_array($action, $frozen_allowed_actions[$controller])) {
            return true;
        }

        if (!is_array($frozen_allowed_actions[$controller]) && $frozen_allowed_actions[$controller] === '*') {
            return true;
        }

        return false;
    }
}