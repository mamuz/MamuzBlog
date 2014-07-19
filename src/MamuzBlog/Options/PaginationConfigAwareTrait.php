<?php

namespace MamuzBlog\Options;

use Zend\ServiceManager\ServiceLocatorInterface;

trait PaginationConfigAwareTrait
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return integer
     */
    private function getPaginationRangeConfigBy(ServiceLocatorInterface $serviceLocator)
    {
        return $serviceLocator->get('Config')['mamuz-blog']['pagination']['range'];
    }
}
