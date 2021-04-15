<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Component\Controller\AbstractController;
use App\Service\CartServiceInterface;

/**
 * Class Cart
 * @package App\Controller
 */
#[Route("/cart", name: "cart_")]
class Cart extends AbstractController
{
    /**
     * Cart constructor.
     * @param CartServiceInterface $cartService
     */
    public function __construct(
        private CartServiceInterface $cartService
    )
    {
    }

    /**
     * @return Response
     */
    #[Route("/", name: "index")]
    public function indexAction()
    {
        return $this->render();
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    #[Route("/total-count", name: "total_count", methods: ['GET'], condition: "request.isXmlHttpRequest()")]
    public function totalCountAction()
    {
        return $this->json($this->cartService->getTotalCount());
    }

    /**
     * @return Response
     */
    #[Route("/content", name: "content", methods: ['GET'], condition: "request.isXmlHttpRequest()")]
    public function contentAction()
    {
        return $this->json($this->cartService->getContent());
    }

    /**
     * @return Response
     */
    #[Route("/add", name: "add", methods: ['POST'], condition: "request.isXmlHttpRequest()")]
    public function addAction()
    {
        $params = $this->request->toArray();
        $this->cartService->add(number: $params['number']);
        return $this->json([]);
    }

    /**
     * @return Response
     */
    #[Route("/remove", name: "remove", methods: ['POST'], condition: "request.isXmlHttpRequest()")]
    public function removeAction()
    {
        $params = $this->request->toArray();
        $this->cartService->remove(id: $params['id']);
        return $this->json([]);
    }

    /**
     * @return Response
     */
    #[Route("/change-quantity", name: "change_quantity", methods: ['POST'], condition: "request.isXmlHttpRequest()")]
    public function cartChangeQuantityAction()
    {
        $params = $this->request->toArray();
        $this->cartService->changeQuantity(id: $params['id'], quantity: $params['quantity']);
        return $this->json([]);
    }
}