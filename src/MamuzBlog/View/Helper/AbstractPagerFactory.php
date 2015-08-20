<?php

namespace MamuzBlog\View\Helper;

use MamuzBlog\Options\PaginationConfigProviderTrait;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

abstract class AbstractPagerFactory implements FactoryInterface
{
    use PaginationConfigProviderTrait;

    /** @var array */
    protected $rangeConfig;

    /**
     * {@inheritdoc}
     * @return \Zend\View\Helper\HelperInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if ($serviceLocator instanceof ServiceLocatorAwareInterface) {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }

        $this->rangeConfig = $this->getPaginationRangeConfigBy($serviceLocator);
        return $this->createPager();
    }

    /**
     * @return \Zend\View\Helper\HelperInterface
     */
    abstract protected function createPager();
}
