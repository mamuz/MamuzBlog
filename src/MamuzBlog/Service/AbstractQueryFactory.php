<?php

namespace MamuzBlog\Service;

use Doctrine\ORM\EntityManagerInterface;
use MamuzBlog\Options\AbstractPaginationConfigProvider;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

abstract class AbstractQueryFactory extends AbstractPaginationConfigProvider implements FactoryInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
        $this->setEntityManager($entityManager);

        return $this->createQueryService($serviceLocator);
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @return void
     */
    private function setEntityManager(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return EntityManagerInterface
     */
    protected function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return object
     */
    abstract protected function createQueryService(ServiceLocatorInterface $serviceLocator);
}
