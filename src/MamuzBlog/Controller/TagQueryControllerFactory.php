<?php

namespace MamuzBlog\Controller;

class TagQueryControllerFactory extends AbstractQueryControllerFactory
{
    protected function createController()
    {
        /** @var \MamuzBlog\Feature\TagQueryInterface $queryService */
        $queryService = $this->getDomainManager()->get('MamuzBlog\Service\TagQuery');

        return new TagQueryController($queryService);
    }
}
