<?php

namespace MamuzBlog\Controller\Plugin;

use Zend\Mvc\Controller\AbstractController as MvcController;
use Zend\Mvc\Controller\Plugin\AbstractPlugin as ZendAbstractPlugin;

abstract class AbstractPlugin extends ZendAbstractPlugin
{
    /**
     * @return MvcController|null
     */
    protected function getMvcController()
    {
        $controller = $this->getController();
        if ($controller instanceof MvcController) {
            return $controller;
        }

        return null;
    }
}
