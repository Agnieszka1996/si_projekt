<?php
/**
 * Alarm repository.
 */

namespace App\Repository;

use App\Entity\Alarm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * Class AlarmRepository.
 *
 * @method Alarm|null find($id, $lockMode = null, $lockVersion = null)
 * @method Alarm|null findOneBy(array $criteria, array $orderBy = null)
 * @method Alarm[]    findAll()
 * @method Alarm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlarmRepository extends ServiceEntityRepository
{
    /**
     * AlarmRepository constructor.
     *
     * @param \Doctrine\Common\Persistence\ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Alarm::class);
    }

    /**
     * Query all records.
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    public function queryAll(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder();
    }

    /**
     * Get or create new query builder.
     *
     * @param \Doctrine\ORM\QueryBuilder|null $queryBuilder Query builder
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('alarm');
    }
}
