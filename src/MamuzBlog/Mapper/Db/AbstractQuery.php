<?php

namespace MamuzBlog\Mapper\Db;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use MamuzBlog\Feature\Pageable;
use MamuzBlog\Options\ConstraintInterface;
use MamuzBlog\Options\RangeInterface;

abstract class AbstractQuery implements Pageable
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var RangeInterface */
    private $range;

    /** @var int */
    private $currentPage = 1;

    /**
     * @param EntityManagerInterface $entityManager
     * @param RangeInterface         $range
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        RangeInterface $range
    ) {
        $this->entityManager = $entityManager;
        $this->range = $range;
    }

    /**
     * @return EntityManagerInterface
     */
    protected function getEntityManager()
    {
        return $this->entityManager;
    }

    public function setCurrentPage($currentPage)
    {
        $this->currentPage = (int) $currentPage;
        return $this;
    }

    /**
     * @param ConstraintInterface $constraint
     * @return Paginator
     */
    protected function createPaginator(ConstraintInterface $constraint)
    {
        $firstResult = $this->range->getOffsetBy($this->currentPage);
        $maxResults = $this->range->getSize();
        $dql = $this->getDql($constraint);

        /** @var \Doctrine\DBAL\Query\QueryBuilder $query */
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setFirstResult($firstResult)->setMaxResults($maxResults);

        if (!$constraint->isEmpty()) {
            $query->setParameters($constraint->toArray());
        }

        return new Paginator($query);
    }

    /**
     * @param ConstraintInterface $constraint
     * @return string
     */
    abstract protected function getDql(ConstraintInterface $constraint);
}
