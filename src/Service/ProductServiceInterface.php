<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\Product;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface ProductServiceInterface
 * @package App\Service
 */
interface ProductServiceInterface
{
    /**
     * @param string $number
     * @param int|null $id
     * @return array
     */
    public function get(string $number, int $id = null): array;

    /**
     * @param int $page
     * @param int $perPage
     * @param array $options
     * @return array
     */
    public function getList(int $page = 1, int $perPage = 9, array $options = []): array;

    /**
     * @param Product $product
     * @return array
     */
    public function convert(Product $product): array;

    /**
     * @param iterable|array $products
     * @return ArrayCollection
     */
    public function convertList(iterable $products = []): ArrayCollection;
}