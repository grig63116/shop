<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Component\Controller\AbstractController;
use App\Service\ProductServiceInterface;

/**
 * Class Product
 * @package App\Controller
 */
#[Route("/product", name: "product_")]
class Product extends AbstractController
{

    /**
     * Product constructor.
     * @param ProductServiceInterface $productService
     */
    public function __construct(
        private ProductServiceInterface $productService
    )
    {
    }

    /**
     * @return Response
     */
    #[Route("/list", name: "list", methods: ['GET'], condition: "request.isXmlHttpRequest()")]
    public function listAction()
    {
        $page = (int)$this->request->get('page');
        $perPage = (int)$this->request->get('perPage');
        return $this->json($this->productService->getList(page: $page, perPage: $perPage));
    }
}