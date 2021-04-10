<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;
use App\Entity\Cart;
use App\Entity\Product;
use  Doctrine\ORM\Query\Expr\Join;

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
     * @param $sessionId
     * @param $userId
     * @return QueryBuilder
     */
    public function getCartQueryBuilder($sessionId, $userId): QueryBuilder
    {
        $builder = $this->createQueryBuilder('c');
        $expr = $builder->expr();
        return $builder
            ->select('c, p')
            ->leftJoin(Product::class, 'p', Join::WITH, 'c.productNumber=p.number')
            ->where($expr->eq('c.sessionId', ':sessionId'))
            ->andWhere($expr->eq('c.userId', ':userId'))
            ->setParameters([
                'sessionId' => $sessionId,
                'userId' => $userId
            ]);
    }

    /**
     * @param string $sessionId
     * @param int $userId
     * @return int
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getCartCount(string $sessionId, int $userId): int
    {
        try {
            return (int)$this->getCartCountQueryBuilder($sessionId, $userId)->getQuery()->getSingleScalarResult();
        } catch (\Doctrine\ORM\NoResultException $exception) {
            return 0;
        }
    }

    /**
     * @param $sessionId
     * @param $userId
     * @return QueryBuilder
     */
    public function getCartCountQueryBuilder($sessionId, $userId): QueryBuilder
    {
        $builder = $this->createQueryBuilder('c');
        $expr = $builder->expr();
        return $builder
            ->select('sum(c.quantity)')
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
