<?php

namespace MamuzBlog\Mapper\Db;

use MamuzBlog\Feature\TagQueryInterface;
use MamuzBlog\Options\Constraint;
use MamuzBlog\Options\ConstraintInterface;

class TagQuery extends AbstractQuery implements TagQueryInterface
{
    const REPOSITORY = 'MamuzBlog\Entity\Tag';

    public function findTags()
    {
        return $this->createPaginator(new Constraint);
    }

    protected function getDql(ConstraintInterface $constraint)
    {
        $dql = 'SELECT p, t FROM ' . self::REPOSITORY;

        return $dql;
    }
}
