<?php

namespace MamuzBlog\Service;

use MamuzBlog\Mapper\Db\PostQuery as PostQueryMapper;
use MamuzBlog\Options\PaginationConfigAccessTrait;
use MamuzBlog\Options\Range;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PostQueryFactory implements FactoryInterface
{
    use PaginationConfigAccessTrait;

    /**
     * {@inheritdoc}
     * @return \MamuzBlog\Feature\PostQueryInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \Doctrine\ORM\EntityManagerInterface $entityManager */
        $entityManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
        $rangeConfig = $this->getPaginationRangeConfigBy($serviceLocator);

        $queryMapper = new PostQueryMapper($entityManager, new Range($rangeConfig['post']));
        $queryService = new PostQuery($queryMapper);

        return $queryService;
    }
}
