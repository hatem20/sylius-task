<?php

namespace AppBundle\Repository;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

/**
 * ConstantRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ConstantRepository extends \Doctrine\ORM\EntityRepository implements RepositoryInterface
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

    /**
     * @throws
    */
    public function isSum()
    {
        $qb = $this->createQueryBuilder('p');

        return $qb
            ->select('p.sum')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
