<?php

namespace App\Component\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Interface ControllerInterface
 * @package App\Component\Controller
 */
interface ControllerInterface
{
    /**
     * @param string $template
     * @param array $parameters
     * @param Response|null $response
     * @return Response
     */
    public function render(string $template = '', array $parameters = array(), Response $response = null): Response;

    /**
     * @return string
     */
    public function getTemplate(): string;

    /**
     * @param string $template
     */
    public function setTemplate(string $template): void;

    /**
     * @param string|null $name
     * @return mixed
     */
    public function getAssign(string $name = null);

    /**
     * @param $name
     * @param null $value
     * @return array
     */
    public function assign($name, $value = null): array;
}
