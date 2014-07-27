<?php

namespace MamuzBlog\Service;

use MamuzBlog\Options\PaginationConfigAccessTrait;
use Zend\ServiceManager\FactoryInterface;

abstract class AbstractQueryFactory implements FactoryInterface
{
    use PaginationConfigAccessTrait;
}
