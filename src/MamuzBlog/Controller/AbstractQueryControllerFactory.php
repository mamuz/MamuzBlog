<?php

namespace MamuzBlog\Controller;

use Zend\Mvc\Controller\AbstractController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

abstract class AbstractQueryControllerFactory implements FactoryInterface
{
    /** @var ServiceLocatorInterface */
    private $domainManager;

    /**
     * {@inheritdoc}
     * @return AbstractController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if ($serviceLocator instanceof ServiceLocatorAwareInterface) {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }

        /** @var ServiceLocatorInterface $domainManager */
        $domainManager = $serviceLocator->get('MamuzBlog\DomainManager');
        $this->setDomainManager($domainManager);

        return $this->createController();
    }

    /**
     * @param ServiceLocatorInterface $domainManager
     * @return void
     */
    private function setDomainManager(ServiceLocatorInterface $domainManager)
    {
        $this->domainManager = $domainManager;
    }

    /**
     * @return ServiceLocatorInterface
     */
    protected function getDomainManager()
    {
        return $this->domainManager;
    }

    /**
     * @return AbstractController
     */
    abstract protected function createController();
}
