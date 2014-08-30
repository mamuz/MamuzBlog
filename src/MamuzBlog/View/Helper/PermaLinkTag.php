<?php

namespace MamuzBlog\View\Helper;

class PermaLinkTag extends AbstractHelper
{
    /**
     * {@link render()}
     */
    public function __invoke($tagName)
    {
        return $this->render($tagName);
    }

    /**
     * @param string $tagName
     * @return string
     */
    public function render($tagName)
    {
        $serverUrl = $this->getRenderer()->serverUrl();

        $url = $this->getRenderer()->url(
            'blogPublishedPosts',
            array('tag' => $tagName)
        );

        return $serverUrl . $url;
    }
}
