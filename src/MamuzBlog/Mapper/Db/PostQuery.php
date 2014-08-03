<?php

namespace MamuzBlog\Mapper\Db;

use MamuzBlog\Feature\PostQueryInterface;
use MamuzBlog\Options\Constraint;
use MamuzBlog\Options\ConstraintInterface;

class PostQuery extends AbstractQuery implements PostQueryInterface
{
    const REPOSITORY = 'MamuzBlog\Entity\Post';

    /** @var ConstraintInterface */
    private $constraint;

    public function findActivePostById($id)
    {
        return $this->getEntityManager()->find(self::REPOSITORY, $id);
    }

    public function findActivePosts()
    {
        $this->constraint = new Constraint;
        $this->constraint->add('active', 'p.active = :active', true);

        return $this->createPaginator();
    }

    public function findActivePostsByTag($tag)
    {
        $this->constraint = new Constraint;
        $this->constraint->add('active', 'p.active = :active', 1);
        $this->constraint->add('tag', 'AND t.name = :tag', $tag);

        return $this->createPaginator();
    }

    protected function getQuery()
    {
        if (!$this->constraint->isEmpty()) {
            $constraintString = 'WHERE ' . $this->constraint->toString() . ' ';
        } else {
            $constraintString = '';
        }

        $dql = 'SELECT p, t FROM ' . self::REPOSITORY . ' p LEFT JOIN p.tags t '
            . $constraintString
            . 'ORDER BY p.createdAt DESC';

        $query = $this->getEntityManager()->createQuery($dql);

        if (!$this->constraint->isEmpty()) {
            /** @var \Doctrine\DBAL\Query\QueryBuilder $query */
            $query->setParameters($this->constraint->toArray());
        }

        return $query;
    }
}
