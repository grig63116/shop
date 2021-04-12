<?php

namespace App\Service;

use App\Entity\Cart;
use App\Repository\CartRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
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

    /**
     * CheckoutService constructor.
     * @param ContainerInterface $container
     * @param EntityManagerInterface $em
     * @param SessionInterface $session
     * @param ProductServiceInterface $productService
     */
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

    /**
     * @return array
     */
    public function getCart(): array
    {
        $sessionId = $this->session->getId();
        $userId = $this->getUser() ? $this->getUser()->getId() : 0;
        $content = [
            'sessionId' => $sessionId,
            'userId' => $userId,
            'items' => [],
            'amount' => 0
        ];
        $cart = $this->repository->getCart($sessionId, $userId);
        foreach ($cart as $item) {
            $item['product'] = $this->productService->get($item['productNumber'], $item['productId']);
            $content['items'][] = $item;
            $content['amount'] += $item['price'] * $item['quantity'];
        }
        return $content;
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
        $product = $this->productService->get($number);
        if (empty($product)) {
            return;
        }
        $sessionId = $this->session->getId();
        $userId = $this->getUser() ? $this->getUser()->getId() : 0;
        $cart = $this->repository->getCartItem($number, $sessionId, $userId);
        if (!($cart instanceof Cart)) {
            $cart = new Cart();
            $cart->setSessionId($sessionId);
            $cart->setUserId($userId);
        }
        $cart->setQuantity((int)$cart->getQuantity() + $quantity);
        $cart->setProductId($product['id']);
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
    public function getCartQuantity(): int
    {
        $sessionId = $this->session->getId();
        $userId = $this->getUser() ? $this->getUser()->getId() : 0;

        return $this->repository->getCartQuantity($sessionId, $userId);
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
