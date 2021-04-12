<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Component\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Service\CheckoutServiceInterface;

/**
 * Class Checkout
 * @package App\Controller
 */
#[Route("/checkout", name: "checkout_")]
class Checkout extends AbstractController
{
    /**
     * @var CheckoutServiceInterface
     */
    protected $checkoutService;

    public function __construct(
        CheckoutServiceInterface $checkoutService
    )
    {
        $this->checkoutService = $checkoutService;
    }

    /**
     * @return Response
     */
    #[Route("/cart", name: "cart")]
    public function cartAction()
    {
        return $this->render();
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    #[Route("/cart/quantity", name: "cart_quantity", methods: ['GET'], condition: "request.isXmlHttpRequest()")]
    public function cartQuantityAction()
    {
        return $this->json($this->checkoutService->getCartQuantity());
    }

    /**
     * @return Response
     */
    #[Route("/cart/content", name: "cart_content", methods: ['GET'], condition: "request.isXmlHttpRequest()")]
    public function cartContentAction()
    {
        return $this->json($this->checkoutService->getCart());
    }

    /**
     * @return Response
     */
    #[Route("/add-to-card", name: "add_to_cart", methods: ['GET'], condition: "request.isXmlHttpRequest()")]
    public function addToCartAction()
    {
        $number = $this->request->get('number');
        $this->checkoutService->addToCart(number: $number);
        return $this->json([]);
    }
}