<?php

namespace MamuzBlog\View\Helper;

use Zend\View\Helper\AbstractHelper as ZendAbstractHelper;

abstract class AbstractHelper extends ZendAbstractHelper
{
    /**
     * @return \MamuzBlog\View\Renderer\PhpRenderer
     */
    protected function getRenderer()
    {
        return $this->getView();
    }
}
