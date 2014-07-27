<?php

namespace MamuzBlog\View\Helper;

use MamuzBlog\Options\Range;

class TagPagerFactory extends AbstractPagerFactory
{
    protected function createPager()
    {
        $range = new Range($this->rangeConfig['tag']);
        return new Pager($range, 'blogTags', 'page');
    }
}
