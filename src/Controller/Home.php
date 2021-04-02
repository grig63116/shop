<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Component\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Home
 * @package App\Controller
 */
#[Route("/", name: "home_")]
class Home extends AbstractController
{
    /**
     * @return Response
     */
    #[Route("/", name: "index")]
    public function indexAction()
    {
        return $this->render();
    }
}