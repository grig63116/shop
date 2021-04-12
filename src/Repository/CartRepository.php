<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;
use App\Entity\Cart;

/**
 * @method Cart|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cart|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cart[]    findAll()
 * @method Cart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cart::class);
    }

    /**
     * @param string $sessionId
     * @param int $userId
     * @return array
     */
    public function getCart(string $sessionId, int $userId): array
    {
        return $this->getCartQueryBuilder($sessionId, $userId)->getQuery()->getArrayResult();
    }

    /**
     * @param string $sessionId
     * @param int $userId
     * @return QueryBuilder
     */
    public function getCartQueryBuilder(string $sessionId, int $userId): QueryBuilder
    {
        $builder = $this->createQueryBuilder('c');
        $expr = $builder->expr();
        return $builder
            ->select('c')
            ->where($expr->eq('c.sessionId', ':sessionId'))
            ->andWhere($expr->eq('c.userId', ':userId'))
            ->setParameters([
                'sessionId' => $sessionId,
                'userId' => $userId
            ]);
    }

    /**
     * @param string $productNumber
     * @param string $sessionId
     * @param int $userId
     * @return Cart
     */
    public function getCartItem(string $productNumber, string $sessionId, int $userId): ?Cart
    {
        return $this->findOneBy([
            'sessionId' => $sessionId,
            'userId' => $userId,
            'productNumber' => $productNumber
        ]);
    }

    /**
     * @param string $sessionId
     * @param int $userId
     * @return int
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getCartQuantity(string $sessionId, int $userId): int
    {
        try {
            return (int)$this->getCartQuantityQueryBuilder($sessionId, $userId)->getQuery()->getSingleScalarResult();
        } catch (\Doctrine\ORM\NoResultException $exception) {
            return 0;
        }
    }

    /**
     * @param $sessionId
     * @param $userId
     * @return QueryBuilder
     */
    public function getCartQuantityQueryBuilder($sessionId, $userId): QueryBuilder
    {
        $builder = $this->createQueryBuilder('c');
        $expr = $builder->expr();
        return $builder
            ->select('count(c)')
            ->where($expr->eq('c.sessionId', ':sessionId'))
            ->andWhere($expr->eq('c.userId', ':userId'))
            ->setParameters([
                'sessionId' => $sessionId,
                'userId' => $userId
            ])
            ->groupBy('c.sessionId')
            ->addGroupBy('c.userId');
    }
}
