<?php

namespace MamuzBlog\Mapper\Db;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use MamuzBlog\EventManager\AwareTrait as EventManagerAwareTrait;
use MamuzBlog\EventManager\Event;
use MamuzBlog\Feature\Pageable;
use MamuzBlog\Options\RangeInterface;

abstract class AbstractQuery implements Pageable
{
    use EventManagerAwareTrait;

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

    public function setCurrentPage($currentPage)
    {
        $this->currentPage = (int) $currentPage;
        return $this;
    }

    /**
     * @return EntityManagerInterface
     */
    protected function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @return Paginator
     */
    protected function createPaginator()
    {
        $firstResult = $this->range->getOffsetBy($this->currentPage);
        $maxResults = $this->range->getSize();

        $query = $this->getQuery();
        $query->setFirstResult($firstResult)->setMaxResults($maxResults);

        $results = $this->trigger(Event::PRE_PAGINATION_CREATE, array('query' => $query));
        if ($results->stopped() && ($paginator = $results->last()) instanceof Paginator) {
            return $paginator;
        }

        $paginator = new Paginator($query);

        $this->trigger(Event::POST_PAGINATION_CREATE, array('query' => $query, 'paginator' => $paginator));

        return $paginator;
    }

    /**
     * @return \Doctrine\ORM\Query
     */
    abstract protected function getQuery();
}
