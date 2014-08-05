<?php

namespace MamuzBlog\Mapper\Db;

use MamuzBlog\Feature\TagQueryInterface;

class TagQuery extends AbstractQuery implements TagQueryInterface
{
    const REPOSITORY = 'MamuzBlog\Entity\Tag';

    public function findUsedTags()
    {
        return $this->createPaginator();
    }

    protected function getQuery()
    {
        $dql = 'SELECT t FROM ' . self::REPOSITORY . ' t';
        return $this->getEntityManager()->createQuery($dql);
    }
}
