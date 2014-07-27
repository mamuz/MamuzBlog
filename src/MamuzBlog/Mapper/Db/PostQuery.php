<?php

namespace MamuzBlog\Mapper\Db;

use MamuzBlog\Feature\PostQueryInterface;
use MamuzBlog\Options\Constraint;
use MamuzBlog\Options\ConstraintInterface;

class PostQuery extends AbstractQuery implements PostQueryInterface
{
    const REPOSITORY = 'MamuzBlog\Entity\Post';

    public function findActivePostById($id)
    {
        return $this->getEntityManager()->find(self::REPOSITORY, $id);
    }

    public function findActivePosts()
    {
        $constraint = new Constraint;
        $constraint->add('active', 'p.active = :active', true);

        return $this->createPaginator($constraint);
    }

    public function findActivePostsByTag($tag)
    {
        $constraint = new Constraint;
        $constraint->add('active', 'p.active = :active', 1);
        $constraint->add('tag', 'AND t.name = :tag', $tag);

        return $this->createPaginator($constraint);
    }

    protected function getDql(ConstraintInterface $constraint)
    {
        $constraintString = '';
        if (!$constraint->isEmpty()) {
            $constraintString = 'WHERE ' . $constraint->toString() . ' ';
        }

        $dql = 'SELECT p, t FROM ' . self::REPOSITORY . ' p LEFT JOIN p.tags t '
            . $constraintString
            . 'ORDER BY p.createdAt DESC';

        return $dql;
    }
}
