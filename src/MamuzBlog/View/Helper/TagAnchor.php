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
        $url = $this->getRenderer()->url(
            'blogPublishedPosts',
            array('tag' => $tagName)
        );
        return $this->getRenderer()->anchor($url, 'Go to specific list', $content);

    }
}
