<?php

namespace MamuzBlog\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class QueryControllerFactory implements FactoryInterface
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

        /** @var \MamuzBlog\Feature\QueryInterface $queryService */
        $queryService = $domainManager->get('MamuzBlog\Service\Query');

        /** @var \MamuzBlog\Crypt\AdapterInterface $cryptEngine */
        $cryptEngine = $domainManager->get('MamuzBlog\Crypt\HashIdAdapter');

        $controller = new QueryController($queryService, $cryptEngine);

        return $controller;
    }
}
