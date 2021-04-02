<?php

namespace App\Component\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyAbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

abstract class AbstractController extends SymfonyAbstractController implements ControllerInterface
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var string
     */
    protected $template = '';

    /**
     * @var array
     */
    protected $variables = [];

    public static function getSubscribedServices()
    {
        return array_merge(parent::getSubscribedServices(), [
            'request_stack' => '?' . RequestStack::class,
            'security.csrf.token_manager' => '?' . CsrfTokenManagerInterface::class,
//            'swiftmailer.mailer' => '?' . \Swift_Mailer::class,
        ]);
    }

    /*
     * Inits the controller.
     * Called before evey action of the controller.
     */
    public function preDispatch()
    {
        $this->request = $this->get('request_stack')->getCurrentRequest();

        $this->assign([
            'user' => $this->getUser()
        ]);
    }

    /**
     * @param string $template
     * @param array $parameters
     * @param Response|null $response
     * @return Response
     */
    public function render(string $template = '', array $parameters = array(), Response $response = null): Response
    {
        $parameters = array_merge($this->getAssign(), $parameters);
        $template = $template ?: $this->getTemplate();
        return parent::render($template, $parameters, $response);
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * Sets the template for rendering.
     *
     * @param string $template
     */
    public function setTemplate(string $template): void
    {
        $this->template = $template;
    }

    /**
     * @param string|null $name
     * @return array|mixed
     */
    public function getAssign(string $name = null)
    {
        return !is_null($name) ? $this->variables[$name] : $this->variables;
    }

    /**
     * Assigns a template variable
     *
     * @param array|string $name the template variable name(s)
     * @param mixed $value the value to assign
     * @return array
     */
    public function assign($name, $value = null): array
    {
        $variables = is_array($name) ? $name : [$name => $value];
        $this->addVariables($variables);

        return $this->variables;
    }

    /**
     * @param array $variables
     * @return array
     */
    protected function addVariables($variables = []): array
    {
        foreach ($variables as $name => $value) {
            if ($name) {
                $this->variables[$name] = $value;
            }
        }

        return $this->variables;
    }
}