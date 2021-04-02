<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Component\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Product
 * @package App\Controller
 */
#[Route("/product", name: "product_")]
class Product extends AbstractController
{
    /**
     * @return Response
     */
    #[Route("/{id}", name: "index")]
    public function indexAction()
    {
        return $this->render();
    }
}