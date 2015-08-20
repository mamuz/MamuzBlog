<?php

namespace MamuzBlog\View\Helper;

class Panel extends AbstractHelper
{
    /**
     * {@inheritdoc}
     * {@link render()}
     */
    public function __invoke($header, $content, $footer)
    {
        return $this->render($header, $content, $footer);
    }

    /**
     * @param string $header
     * @param string $content
     * @param string $footer
     * @return string
     */
    public function render($header, $content, $footer)
    {
        $html = '<article class="panel panel-default">' . PHP_EOL
            . '<header class="panel-heading"><h3 class="panel-title">' . $header . '</h3></header>' . PHP_EOL
            . '<div class="panel-body"> ' . PHP_EOL
            . $content . PHP_EOL
            . '</div>' . PHP_EOL
            . '<div class="panel-footer">' . PHP_EOL
            . $footer . PHP_EOL
            . '</div>' . PHP_EOL
            . '</article>';

        return $html;
    }
}
