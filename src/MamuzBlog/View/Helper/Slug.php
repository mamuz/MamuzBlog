<?php

namespace MamuzBlog\View\Helper;

use Cocur\Slugify\SlugifyInterface;
use Zend\View\Helper\AbstractHelper as ZendAbstractHelper;

class Slug extends ZendAbstractHelper
{
    /** @var SlugifyInterface */
    private $filter;

    /**
     * @param SlugifyInterface $filter
     */
    public function __construct(SlugifyInterface $filter)
    {
        $this->filter = $filter;
    }

    /**
     * {@link filter()}
     */
    public function __invoke($value)
    {
        return $this->filter($value);
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    public function filter($value)
    {
        return $this->filter->slugify($value);
    }
}
