<?php

namespace MamuzBlog\Options;

use Zend\ServiceManager\ServiceLocatorInterface;

trait PaginationConfigAccessTrait
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return array
     */
    private function getPaginationRangeConfigBy(ServiceLocatorInterface $serviceLocator)
    {
        return $serviceLocator->get('Config')['mamuz-blog']['pagination']['range'];
    }
}
