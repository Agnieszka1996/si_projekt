<?php
/**
 * TasklistAlarm repository.
 */

namespace App\Repository;

use App\Entity\TasklistAlarm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * Class TasklistAlarmRepository.
 *
 * @method TasklistAlarm|null find($id, $lockMode = null, $lockVersion = null)
 * @method TasklistAlarm|null findOneBy(array $criteria, array $orderBy = null)
 * @method TasklistAlarm[]    findAll()
 * @method TasklistAlarm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TasklistAlarmRepository extends ServiceEntityRepository
{
    /**
     * Items per page.
     *
     * Use constants to define configuration options that rarely change instead
     * of specifying them in app/config/config.yml.
     * See https://symfony.com/doc/current/best_practices.html#configuration
     *
     * @constant int
     */
    const PAGINATOR_ITEMS_PER_PAGE = 5;

    /**
     * TasklistAlarmRepository constructor.
     *
     * @param \Doctrine\Common\Persistence\ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TasklistAlarm::class);
    }

    /**
     * Query all records.
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    public function queryAll(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->select('tasklistalarm', 'tasklist')
            ->innerJoin('tasklistalarm.tasklist', 'tasklist')
            ->orderBy('tasklistalarm.name', 'DESC');
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
        return $queryBuilder ?? $this->createQueryBuilder('tasklistalarm');
    }
}