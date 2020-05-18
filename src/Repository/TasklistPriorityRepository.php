<?php
/**
 * TasklistPriority repository.
 */

namespace App\Repository;

use App\Entity\TasklistPriority;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * Class TasklistPriorityRepository.
 *
 * @method TasklistPriority|null find($id, $lockMode = null, $lockVersion = null)
 * @method TasklistPriority|null findOneBy(array $criteria, array $orderBy = null)
 * @method TasklistPriority[]    findAll()
 * @method TasklistPriority[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TasklistPriorityRepository extends ServiceEntityRepository
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
     * TasklistPriorityRepository constructor.
     *
     * @param \Doctrine\Common\Persistence\ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TasklistPriority::class);
    }

    /**
     * Query all records.
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    public function queryAll(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->select('tasklistpriority', 'tasklist')
            ->innerJoin('tasklistpriority.tasklist', 'tasklist')
            ->orderBy('tasklistpriority.name', 'DESC');
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
        return $queryBuilder ?? $this->createQueryBuilder('tasklistpriority');
    }
}