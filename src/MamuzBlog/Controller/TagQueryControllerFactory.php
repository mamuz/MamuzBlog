<?php

namespace MamuzBlog\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TagQueryControllerFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     * @return \Zend\Mvc\Controller\AbstractController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if ($serviceLocator instanceof ServiceLocatorAwareInterface) {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }
        /** @var ServiceLocatorInterface $domainManager */
        $domainManager = $serviceLocator->get('MamuzBlog\DomainManager');

        /** @var \MamuzBlog\Feature\TagQueryInterface $queryService */
        $queryService = $domainManager->get('MamuzBlog\Service\TagQuery');

        $controller = new TagQueryController($queryService);

        return $controller;
    }
}
