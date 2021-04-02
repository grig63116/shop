<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Component\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Account
 * @package App\Controller
 */
#[Route("/account", name: "account_")]
class Account extends AbstractController
{
    /**
     * @return Response
     */
    #[Route("/", name: "index")]
    public function indexAction()
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('authentication_login');
        }
        return $this->render();
    }
}