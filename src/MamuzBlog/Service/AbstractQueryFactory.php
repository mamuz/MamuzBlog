<?php

namespace MamuzBlog\Service;

use Doctrine\ORM\EntityManagerInterface;
use MamuzBlog\Options\PaginationConfigProviderTrait;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

abstract class AbstractQueryFactory implements FactoryInterface
{
    use PaginationConfigProviderTrait;

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var array */
    protected $rangeConfig;

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
        $this->setEntityManager($entityManager);

        $this->rangeConfig = $this->getPaginationRangeConfigBy($serviceLocator);

        return $this->createQueryService();
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
     * @return object
     */
    abstract protected function createQueryService();
}
