<?php

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class ProductService
 * @package App\Service
 */
class ProductService implements ProductServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var ProductRepository
     */
    private $repository;

    /**
     * @var PaginatorInterface
     */
    private $paginator;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * ProductService constructor.
     * @param EntityManagerInterface $em
     * @param PaginatorInterface $paginator
     * @param SerializerInterface $serializer
     */
    public function __construct(
        EntityManagerInterface $em,
        PaginatorInterface $paginator,
        SerializerInterface $serializer
    )
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository(Product::class);
        $this->paginator = $paginator;
        $this->serializer = $serializer;
    }

    /**
     * @param string $number
     * @return array
     */
    public function getByNumber(string $number): array
    {
        $product = $this->repository->findOneBy([
            'number' => $number
        ]);
        if (!($product instanceof Product)) {
            return [];
        }

        return $this->convertProducts($product)->get($product->getNumber());
    }

    /**
     * @param int $page
     * @param int $perPage
     * @param array $options
     * @return PaginationInterface
     */
    public function getList(int $page = 1, int $perPage = 9, array $options = []): array
    {
        $queryBuilder = $this->repository->getProductsQueryBuilder();
        $pagination = $this->paginator->paginate(
            $queryBuilder,
            $page,
            $perPage,
            $options
        );
        return [
            'page' => $pagination->getCurrentPageNumber(),
            'perPage' => $pagination->getItemNumberPerPage(),
            'total' => $pagination->getTotalItemCount(),
            'products' => $this->convertProducts(...$pagination->getItems())
        ];
    }

    /**
     * @param Product ...$products
     * @return ArrayCollection
     */
    public function convertProducts(Product ...$products): ArrayCollection
    {
        $data = [];
        foreach ($products as $product) {
            $product = $this->serializer->normalize($product, null, [AbstractNormalizer::IGNORED_ATTRIBUTES => ['password']]);
            $data[$product['number']] = $product;
        }
        return new ArrayCollection($data);
    }
}
