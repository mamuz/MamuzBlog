<?php

namespace MamuzBlog\View\Helper;

class AnchorBookmark extends Anchor
{
    protected function getTemplate()
    {
        return '<a title="%1$s" href="%2$s" rel="bookmark"%3$s>%4$s</a>';
    }
}
