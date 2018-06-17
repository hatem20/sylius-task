<?php
/**
 * Created by PhpStorm.
 * User: hatem
 * Date: 6/16/18
 * Time: 5:22 AM
 */

namespace AppBundle\Repository;

use Doctrine\ORM\QueryBuilder;
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

    public function getProductStockByProductId(): QueryBuilder
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

    /**
     * @param $productId int
     * @param $stockRoomId int
     * @return int
     * @throws
     */
    public function getAmountByProductIdAndStockRoomId(int $productId,int  $stockRoomId): int
    {
        $qb = $this->createQueryBuilder('p');

        $amount = $qb
            ->select('p.amount')
            ->where('p.product = :product_id')
            ->andWhere('p.stockRoom = :stockroom_id')
            ->setParameter('product_id', $productId)
            ->setParameter('stockroom_id', $stockRoomId)
            ->getQuery()
            ->getSingleScalarResult();

        return $amount;
    }

    public function updateStockRoomAmount(int $stockRoomId, int $productId, int $amount): void
    {
        $qb = $this->createQueryBuilder('p');

        $q = $qb
            ->update('AppBundle:ProductStock','p')
            ->set('p.amount', $amount)
            ->where('p.stockRoom = :stockroom_id')
            ->andWhere('p.product = :product_id')
            ->setParameter('stockroom_id', $stockRoomId)
            ->setParameter('product_id', $productId)
            ->getQuery();

        $q->execute();
    }
}