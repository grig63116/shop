<?php declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use App\Repository\CartRepository;
use App\Entity\Cart;

/**
 * Class CartService
 * @package App\Service
 */
class CartService implements CartServiceInterface
{
    /**
     * @var CartRepository
     */
    private $repository;

    /**
     * CartService constructor.
     * @param ContainerInterface $container
     * @param EntityManagerInterface $em
     * @param SessionInterface $session
     * @param ProductServiceInterface $productService
     */
    public function __construct(
        private ContainerInterface $container,
        private EntityManagerInterface $em,
        private SessionInterface $session,
        private ProductServiceInterface $productService
    )
    {
        $this->repository = $this->em->getRepository(Cart::class);
    }

    /**
     * @param string $oldSessionId
     * @param string $newSessionId
     * @param int $userId
     */
    public function migrate(string $oldSessionId, string $newSessionId, int $userId): void
    {
        $this->repository->migrateUserCart(oldSessionId: $oldSessionId, newSessionId: $newSessionId, userId: $userId);
    }

    /**
     * @return array
     */
    public function getContent(): array
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
    public function add(string $number = '', int $quantity = 1): void
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
        $cart = $this->repository->getItemByNumber(productNumber: $number, sessionId: $sessionId, userId: $userId);
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
     * @param int $id
     */
    public function remove(int $id): void
    {
        $sessionId = $this->session->getId();
        $userId = $this->getUser() ? $this->getUser()->getId() : 0;

        $cartItem = $this->repository->getItemById(id: $id, sessionId: $sessionId, userId: $userId);
        if ($cartItem instanceof Cart) {
            $this->em->remove($cartItem);
            $this->em->flush();
        }
    }

    /**
     * @return int
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getTotalCount(): int
    {
        $sessionId = $this->session->getId();
        $userId = $this->getUser() ? $this->getUser()->getId() : 0;

        return $this->repository->getTotalCount($sessionId, $userId);
    }

    /**
     * @param int $id
     * @param int $quantity
     */
    public function changeQuantity(int $id, int $quantity): void
    {
        if ($quantity < 1) {
            return;
        }
        $sessionId = $this->session->getId();
        $userId = $this->getUser() ? $this->getUser()->getId() : 0;

        $cartItem = $this->repository->getItemById(id: $id, sessionId: $sessionId, userId: $userId);
        if ($cartItem instanceof Cart && $cartItem->getQuantity() !== $quantity) {
            $cartItem->setQuantity($quantity);
            $this->em->persist($cartItem);
            $this->em->flush();
        }
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
