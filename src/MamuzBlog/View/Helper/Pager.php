<?php

namespace MamuzBlog\View\Helper;

use MamuzBlog\Options\RangeInterface;
use Zend\View\Helper\AbstractHelper;

class Pager extends AbstractHelper
{
    /** @var RangeInterface */
    private $range;

    /** @var string */
    private $html;

    public function __construct(RangeInterface $range)
    {
        $this->range = $range;
    }

    /**
     * {@link render()}
     */
    public function __invoke(\Countable $collection, $route, array $params, $pageKey = 'page')
    {
        return $this->render($collection, $route, $params, $pageKey);
    }

    /**
     * @param \Countable $collection
     * @param string     $route
     * @param array      $params
     * @param string     $pageKey
     * @return string
     */
    public function render(\Countable $collection, $route, array $params, $pageKey = 'page')
    {
        $this->html = '';

        $totalCount = count($collection);
        $pagesCount = ceil($totalCount / $this->range->getSize());

        if ($pagesCount < 2) {
            return $this->html;
        }

        $paramsNext = $paramsPrev = $params;
        $paramsNext[$pageKey]++;
        $paramsPrev[$pageKey]--;

        $currentPage = $params[$pageKey];

        if ($currentPage > 1) {
            $url = $this->buildUrl($route, $paramsPrev);
            $this->html .= $this->buildAnchor($url, 'prev', '&laquo;');
        }

        if ($currentPage < $pagesCount) {
            $url = $this->buildUrl($route, $paramsNext);
            $this->html .= $this->buildAnchor($url, 'next', '&raquo;');
        }

        return $this->html;
    }

    /**
     * @param string $route
     * @param mixed  $param
     * @return string
     */
    private function buildUrl($route, $param)
    {
        /** @var $renderer \Zend\View\Renderer\PhpRenderer */
        $renderer = $this->getView();
        return $renderer->url($route, $param);
    }

    /**
     * @param string $url
     * @param string $class
     * @param string $text
     * @return string
     */
    private function buildAnchor($url, $class, $text)
    {
        return '<a class="' . $class . '" href="' . $url . '">' . $text . '</a>' . PHP_EOL;
    }
}
