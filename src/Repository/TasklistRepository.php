<?php
/**
 * Tasklist repository.
 */

namespace App\Repository;

use App\Entity\Tasklist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * Class TasklistRepository.
 *
 * @method Tasklist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tasklist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tasklist[]    findAll()
 * @method Tasklist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TasklistRepository extends ServiceEntityRepository
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
     * TasklistRepository constructor.
     *
     * @param \Doctrine\Common\Persistence\ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tasklist::class);
    }

    /**
     * Query all records.
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    public function queryAll(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->select('tasklist', 'category')
            ->innerJoin('tasklist.category', 'category')
            ->orderBy('tasklist.term', 'DESC');
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
        return $queryBuilder ?? $this->createQueryBuilder('tasklist');
    }

    /**
     * Save record.
     *
     * @param \App\Entity\Tasklist $tasklist Tasklist entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Tasklist $tasklist): void
    {
        $this->_em->persist($tasklist);
        $this->_em->flush($tasklist);
    }

    /**
     * Delete record.
     *
     * @param \App\Entity\Tasklist $tasklist Tasklist entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Tasklist $tasklist): void
    {
        $this->_em->remove($tasklist);
        $this->_em->flush($tasklist);
    }
}