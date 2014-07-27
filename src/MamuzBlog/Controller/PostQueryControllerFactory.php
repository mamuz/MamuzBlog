<?php

namespace MamuzBlog\Controller;

class PostQueryControllerFactory extends AbstractQueryControllerFactory
{
    protected function createController()
    {
        /** @var \MamuzBlog\Feature\PostQueryInterface $queryService */
        $queryService = $this->getDomainManager()->get('MamuzBlog\Service\PostQuery');

        /** @var \MamuzBlog\Crypt\AdapterInterface $cryptEngine */
        $cryptEngine = $this->getDomainManager()->get('MamuzBlog\Crypt\HashIdAdapter');

        return new PostQueryController($queryService, $cryptEngine);
    }
}
