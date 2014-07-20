<?php

namespace MamuzBlog\View\Helper;

class Anchor extends AbstractHelper
{
    /**
     * {@link render()}
     */
    public function __invoke($href, $title, $content, $class = null)
    {
        return $this->render($href, $title, $content, $class);
    }

    /**
     * @param string $href
     * @param string $title
     * @param string $content
     * @param string|null $class
     * @return string
     */
    public function render($href, $title, $content, $class = null)
    {
        $title = $this->getRenderer()->translate($title);
        $title = $this->getRenderer()->escapeHtmlAttr($title);

        if (is_string($class)) {
            $class = ' class="' . $class . '"';
        } else {
            $class = '';
        }

        return '<a title="' . $title . '" href="' . $href . '"' . $class . '> '. $content . ' </a>';
    }
}
