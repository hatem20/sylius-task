<?php
/**
 * Created by PhpStorm.
 * User: hatem
 * Date: 6/16/18
 * Time: 5:22 AM
 */

namespace AppBundle\Repository;

use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

class ProductStockRepository extends \Doctrine\ORM\EntityRepository implements RepositoryInterface
{
    public function add(ResourceInterface $resource): void
    {
        // TODO: Implement add() method.
    }

    public function remove(ResourceInterface $resource): void
    {
        // TODO: Implement remove() method.
    }

    public function createPaginator(array $criteria = [], array $sorting = []): iterable
    {
        // TODO: Implement createPaginator() method.
    }

    public function getProductStockByProductId()
    {
        /*
         * XXXX this should never be done it's just a hack
         * @todo find the more clean way to get parameter passed from product grid
         */
        $productId = $_GET['productId'] ?? '';

        $qb = $this->createQueryBuilder('p');

        if (isset($productId) && $productId !== '') {
            return $qb
                ->select('p')
                ->where('p.product = :product_id')
                ->setParameter('product_id', $productId);
        } else {
            return $qb
                ->select('p')
                ->orderBy('p.product');
        }
    }
}