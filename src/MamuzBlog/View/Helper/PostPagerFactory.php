<?php

namespace MamuzBlog\View\Helper;

use MamuzBlog\Options\Range;

class PostPagerFactory extends AbstractPagerFactory
{
    protected function createPager()
    {
        $range = new Range($this->rangeConfig['post']);
        return new Pager($range, 'blogActivePosts', 'page');
    }
}
