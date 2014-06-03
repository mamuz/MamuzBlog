<?php

namespace MamuzBlog\Service;

use MamuzBlog\Mapper\Db\Query as QueryMapper;
use MamuzBlog\Options\Range;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class QueryFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     * @return \MamuzBlog\Feature\QueryInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \Doctrine\ORM\EntityManagerInterface $entityManager */
        $entityManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
        $config = $serviceLocator->get('Config')['mamuz-blog']['pagination'];

        $queryMapper = new QueryMapper($entityManager, new Range($config['range']));
        $queryService = new Query($queryMapper);

        return $queryService;
    }
}
