<?php

namespace MamuzBlog\Service;

use MamuzBlog\Mapper\Db\TagQuery as TagQueryMapper;
use MamuzBlog\Options\Range;
use Zend\ServiceManager\ServiceLocatorInterface;

class TagQueryFactory extends AbstractQueryFactory
{
    /**
     * {@inheritdoc}
     * @return \MamuzBlog\Feature\TagQueryInterface
     */
    public function createQueryService(ServiceLocatorInterface $serviceLocator)
    {
        $rangeConfig = $this->getPaginationRangeConfigBy($serviceLocator);

        $queryMapper = new TagQueryMapper($this->getEntityManager(), new Range($rangeConfig['tag']));
        $queryService = new TagQuery($queryMapper);

        return $queryService;
    }
}
