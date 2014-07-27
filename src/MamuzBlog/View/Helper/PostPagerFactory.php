<?php

namespace MamuzBlog\View\Helper;

use MamuzBlog\Options\AbstractPaginationConfigProvider;
use MamuzBlog\Options\Range;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;

class PostPagerFactory extends AbstractPaginationConfigProvider implements FactoryInterface
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

        $rangeConfig = $this->getPaginationRangeConfigBy($serviceLocator);
        $range = new Range($rangeConfig['post']);

        return new Pager($range, 'blogActivePosts', 'page');
    }
}
