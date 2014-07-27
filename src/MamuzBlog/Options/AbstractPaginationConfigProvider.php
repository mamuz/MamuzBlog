<?php

namespace MamuzBlog\Options;

use Zend\ServiceManager\ServiceLocatorInterface;

abstract class AbstractPaginationConfigProvider
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return array
     */
    protected function getPaginationRangeConfigBy(ServiceLocatorInterface $serviceLocator)
    {
        return $serviceLocator->get('Config')['mamuz-blog']['pagination']['range'];
    }
}
