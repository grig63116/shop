<?php

namespace App\Service;

use App\Entity\Cart;
use App\Repository\CartRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class CheckoutService
 * @package App\Service
 */
class CheckoutService implements CheckoutServiceInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var CartRepository
     */
    private $repository;

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var ProductServiceInterface
     */
    private $productService;

    public function __construct(
        ContainerInterface $container,
        EntityManagerInterface $em,
        SessionInterface $session,
        ProductServiceInterface $productService
    )
    {
        $this->container = $container;
        $this->em = $em;
        $this->repository = $this->em->getRepository(Cart::class);
        $this->session = $session;
        $this->productService = $productService;
    }

    public function getCart(): array
    {
        $sessionId = $this->session->getId();
        $userId = $this->getUser() ? $this->getUser()->getId() : 0;
        $cart = $this->repository->getCart($sessionId, $userId);
        dump($cart);exit;
        return [];
    }

    /**
     * @param string $number
     * @param int $quantity
     */
    public function addToCart(string $number = '', int $quantity = 1): void
    {
        if ($quantity < 1) {
            $quantity = 1;
        }
        $product = $this->productService->getByNumber($number);
        if (empty($product)) {
            return;
        }
        $sessionId = $this->session->getId();
        $userId = $this->getUser() ? $this->getUser()->getId() : 0;
        $cart = $this->getCartItem($number, $sessionId, $userId);
        if (!($cart instanceof Cart)) {
            $cart = new Cart();
            $cart->setSessionId($sessionId);
            $cart->setUserId($userId);
        }
        $cart->setQuantity((int)$cart->getQuantity() + $quantity);
        $cart->setProductNumber($product['number']);
        $cart->setProductName($product['name']);
        $cart->setPrice($product['price']);
        $this->em->persist($cart);
        $this->em->flush();
    }

    /**
     * @return int
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getCartCount(): int
    {
        $sessionId = $this->session->getId();
        $userId = $this->getUser() ? $this->getUser()->getId() : 0;

        return $this->repository->getCartCount($sessionId, $userId);
    }

    /**
     * @param string $number
     * @param string $sessionId
     * @param int $userId
     * @return Cart|null
     */
    protected function getCartItem(string $number, string $sessionId, int $userId = 0): ?Cart
    {
        return $this->repository->findOneBy([
            'productNumber' => $number,
            'sessionId' => $sessionId,
            'userId' => $userId,
        ]);
    }

    /**
     * Get a user from the Security Token Storage.
     *
     * @return UserInterface|object|null
     *
     * @throws \LogicException If SecurityBundle is not available
     *
     * @see TokenInterface::getUser()
     *
     * @final
     */
    protected function getUser()
    {
        if (!$this->container->has('security.token_storage')) {
            throw new \LogicException('The SecurityBundle is not registered in your application. Try running "composer require symfony/security-bundle".');
        }

        if (null === $token = $this->container->get('security.token_storage')->getToken()) {
            return null;
        }

        if (!\is_object($user = $token->getUser())) {
            // e.g. anonymous authentication
            return null;
        }

        return $user;
    }
}
