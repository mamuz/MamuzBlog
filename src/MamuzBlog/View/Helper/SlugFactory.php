<?php

namespace MamuzBlog\View\Helper;

use Cocur\Slugify\Slugify;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SlugFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @return \Zend\View\Helper\HelperInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $filter = new Slugify;

        return new Slug($filter);
    }
}
