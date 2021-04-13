<?php

namespace App\Service;

use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\ProductRepository;
use App\Entity\Product;

/**
 * Class ProductService
 * @package App\Service
 */
class ProductService implements ProductServiceInterface
{

    /**
     * @var ProductRepository
     */
    private $repository;

    /**
     * ProductService constructor.
     * @param EntityManagerInterface $em
     * @param PaginatorInterface $paginator
     * @param SerializerInterface $serializer
     */
    public function __construct(
        private EntityManagerInterface $em,
        private PaginatorInterface $paginator,
        private SerializerInterface $serializer
    )
    {
        $this->repository = $this->em->getRepository(Product::class);
    }


    /**
     * @param string $number
     * @param int|null $id
     * @return array
     */
    public function get(string $number, int $id = null): array
    {
        $params = [
            'number' => $number
        ];
        if (!empty($id)) {
            $params['id'] = $id;
        }
        $product = $this->repository->findOneBy($params);
        if (!($product instanceof Product)) {
            return [];
        }

        return $this->convertList([$product])->get($product->getNumber());
    }

    /**
     * @param int $page
     * @param int $perPage
     * @param array $options
     * @return array
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
            'products' => $this->convertList($pagination->getItems())
        ];
    }

    /**
     * @param iterable|array $products
     * @return ArrayCollection
     */
    public function convertList(iterable $products = []): ArrayCollection
    {
        $data = [];
        foreach ($products as $product) {
            $product = $this->serializer->normalize($product);
            $data[$product['number']] = $product;
        }
        return new ArrayCollection($data);
    }
}
