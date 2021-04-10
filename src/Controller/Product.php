<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Component\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Service\ProductServiceInterface;

/**
 * Class Product
 * @package App\Controller
 */
#[Route("/product", name: "product_")]
class Product extends AbstractController
{
    /**
     * @var ProductServiceInterface
     */
    protected $productService;

    public function __construct(
        ProductServiceInterface $productService
    )
    {
        $this->productService = $productService;
    }

    /**
     * @return Response
     */
    #[Route("/list", name: "list", methods: ['GET'], condition: "request.isXmlHttpRequest()")]
    public function listAction()
    {
        $page = $this->request->get('page');
        $perPage = $this->request->get('perPage');
        return $this->json($this->productService->getList(page: $page, perPage: $perPage));
    }
}