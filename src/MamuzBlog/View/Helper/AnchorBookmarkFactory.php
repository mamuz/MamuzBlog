<?php

namespace MamuzBlog\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AnchorBookmarkFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     * @return \Zend\View\Helper\HelperInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new Anchor('<a title="%1$s" href="%2$s" rel="bookmark"%3$s>%4$s</a>');
    }
}
