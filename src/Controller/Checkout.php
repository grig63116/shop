<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Component\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Checkout
 * @package App\Controller
 */
#[Route("/checkout", name: "checkout_")]
class Checkout extends AbstractController
{
    /**
     * @return Response
     */
    #[Route("/cart", name: "cart")]
    public function indexAction()
    {
        return $this->render();
    }
}