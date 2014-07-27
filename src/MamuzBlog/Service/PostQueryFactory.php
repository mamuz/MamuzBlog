<?php

namespace MamuzBlog\Service;

use MamuzBlog\Mapper\Db\PostQuery as PostQueryMapper;
use MamuzBlog\Options\Range;

class PostQueryFactory extends AbstractQueryFactory
{
    /**
     * @return \MamuzBlog\Feature\PostQueryInterface
     */
    public function createQueryService()
    {
        $queryMapper = new PostQueryMapper($this->getEntityManager(), new Range($this->rangeConfig['post']));
        $queryService = new PostQuery($queryMapper);

        return $queryService;
    }
}
