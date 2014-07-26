<?php

namespace MamuzBlog\Mapper\Db;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use MamuzBlog\Feature\TagQueryInterface;
use MamuzBlog\Options\Constraint;
use MamuzBlog\Options\ConstraintInterface;
use MamuzBlog\Options\RangeInterface;

class TagQuery implements TagQueryInterface
{
    const REPOSITORY = 'MamuzBlog\Entity\Tag';

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

    public function findTags()
    {
        return $this->createPaginator(new Constraint);
    }

    private function createPaginator(ConstraintInterface $constraint)
    {
        $firstResult = $this->range->getOffsetBy($this->currentPage);
        $maxResults = $this->range->getSize();
        $constraintString = '';

        if (!$constraint->isEmpty()) {
            $constraintString = 'WHERE ' . $constraint->toString() . ' ';
        }

        $dql = 'SELECT p, t FROM ' . self::REPOSITORY . ' p LEFT JOIN p.tags t '
            . $constraintString
            . 'ORDER BY p.createdAt DESC';

        $query = $this->entityManager->createQuery($dql);
        $query->setFirstResult($firstResult)->setMaxResults($maxResults);

        if (!$constraint->isEmpty()) {
            $query->setParameters($constraint->toArray());
        }

        return new Paginator($query);
    }
}
