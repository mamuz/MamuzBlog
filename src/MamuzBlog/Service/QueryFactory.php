<?php

namespace MamuzBlog\Service;

use MamuzBlog\Mapper\Db\Query as QueryMapper;
use MamuzBlog\Options\PaginationConfigAwareTrait;
use MamuzBlog\Options\Range;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class QueryFactory implements FactoryInterface
{
    use PaginationConfigAwareTrait;

    /**
     * {@inheritdoc}
     * @return \MamuzBlog\Feature\QueryInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \Doctrine\ORM\EntityManagerInterface $entityManager */
        $entityManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
        $rangeConfig = $this->getPaginationRangeConfigBy($serviceLocator);

        $queryMapper = new QueryMapper($entityManager, new Range($rangeConfig));
        $queryService = new Query($queryMapper);

        return $queryService;
    }
}
