<?php

namespace MamuzBlog\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TagListFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     * @return \Zend\View\Helper\HelperInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if ($serviceLocator instanceof ServiceLocatorAwareInterface) {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }

        /** @var \Zend\Mvc\Application $application */
        $application = $serviceLocator->get('Application');
        $mvcEvent = $application->getMvcEvent();

        /** @var ServiceLocatorInterface $domainManager */
        $domainManager = $serviceLocator->get('MamuzBlog\DomainManager');
        /** @var \MamuzBlog\Feature\TagQueryInterface $tagQueryService */
        $tagQueryService = $domainManager->get('MamuzBlog\Service\TagQuery');

        return new TagList($mvcEvent, $tagQueryService);
    }

}

