<?php

namespace App\Service;

use App\Entity\Product;
use Doctrine\Common\Collections\ArrayCollection;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface ProductServiceInterface
 * @package App\Service
 */
interface ProductServiceInterface
{
    /**
     * @param int $page
     * @param int $perPage
     * @param array $options
     * @return PaginationInterface
     */
    public function getList(int $page = 1, int $perPage = 9, array $options = []): array;

    /**
     * @param Product ...$products
     * @return ArrayCollection
     */
    public function convertProducts(Product ...$products): ArrayCollection;
}