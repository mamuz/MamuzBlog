<?php

namespace MamuzBlog\View\Helper;

class TagAnchor extends AbstractHelper
{
    /**
     * {@inheritdoc}
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
        $url = $this->getRenderer()->permaLinkTag($tagName);

        return $this->getRenderer()->anchorBookmark($url, 'Go to specific list', $content);
    }
}
