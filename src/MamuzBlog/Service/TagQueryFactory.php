<?php

namespace MamuzBlog\Service;

use MamuzBlog\Mapper\Db\TagQuery as TagQueryMapper;
use MamuzBlog\Options\Range;

class TagQueryFactory extends AbstractQueryFactory
{
    /**
     * @return \MamuzBlog\Feature\TagQueryInterface
     */
    public function createQueryService()
    {
        $queryMapper = new TagQueryMapper($this->getEntityManager(), new Range($this->rangeConfig['tag']));
        $queryService = new TagQuery($queryMapper);

        return $queryService;
    }
}
