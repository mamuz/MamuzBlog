<?php

namespace MamuzBlog\View\Helper;

class PermaLinkTag extends AbstractHelper
{
    /**
     * {@link render()}
     */
    public function __invoke($tagName = null)
    {
        return $this->render($tagName);
    }

    /**
     * @param string|null $tagName
     * @return string
     */
    public function render($tagName = null)
    {
        $serverUrl = $this->getRenderer()->serverUrl();

        $url = $this->getRenderer()->url(
            'blogPublishedPosts',
            array('tag' => $tagName)
        );

        return $serverUrl . $url;
    }
}
