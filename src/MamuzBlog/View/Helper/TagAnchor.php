<?php

namespace MamuzBlog\View\Helper;

class TagAnchor extends AbstractHelper
{
    /**
     * {@link render()}
     */
    public function __invoke($tagName, $content)
    {
        return $this->render($tagName, $content);
    }

    /**
     * @param string $tagName
     * @param string $content
     * @return string
     */
    public function render($tagName, $content)
    {
        $serverUrl = $this->getRenderer()->serverUrl();

        $url = $this->getRenderer()->url(
            'blogPublishedPosts',
            array('tag' => $tagName)
        );
        return $this->getRenderer()->anchorBookmark($serverUrl . $url, 'Go to specific list', $content);

    }
}
