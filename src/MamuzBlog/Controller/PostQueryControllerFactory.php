<?php

namespace MamuzBlog\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PostQueryControllerFactory implements FactoryInterface
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

        /** @var \MamuzBlog\Feature\PostQueryInterface $queryService */
        $queryService = $domainManager->get('MamuzBlog\Service\PostQuery');

        /** @var \MamuzBlog\Crypt\AdapterInterface $cryptEngine */
        $cryptEngine = $domainManager->get('MamuzBlog\Crypt\HashIdAdapter');

        $controller = new PostQueryController($queryService, $cryptEngine);

        return $controller;
    }
}
