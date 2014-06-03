<?php

namespace MamuzBlog\DomainManager;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;

class Factory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     * @return ServiceLocatorInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $domainManager = new ServiceManager;
        /** @var ServiceManager $serviceLocator */
        $domainManager->addPeeringServiceManager($serviceLocator);

        return $domainManager;
    }
}
