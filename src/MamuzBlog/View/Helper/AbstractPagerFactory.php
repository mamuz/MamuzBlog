<?php

namespace MamuzBlog\View\Helper;

use MamuzBlog\Options\AbstractPaginationConfigProvider;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;

abstract class AbstractPagerFactory extends AbstractPaginationConfigProvider implements FactoryInterface
{
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
