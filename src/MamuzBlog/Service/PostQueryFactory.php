<?php

namespace MamuzBlog\Service;

use MamuzBlog\Mapper\Db\PostQuery as PostQueryMapper;
use MamuzBlog\Options\Range;
use Zend\ServiceManager\ServiceLocatorInterface;

class PostQueryFactory extends AbstractQueryFactory
{
    /**
     * {@inheritdoc}
     * @return \MamuzBlog\Feature\PostQueryInterface
     */
    public function createQueryService(ServiceLocatorInterface $serviceLocator)
    {
        $queryMapper = new PostQueryMapper($this->getEntityManager(), new Range($this->rangeConfig['post']));
        $queryService = new PostQuery($queryMapper);

        return $queryService;
    }
}
