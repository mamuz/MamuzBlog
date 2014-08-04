<?php

namespace MamuzBlog\View\Helper;

use MamuzBlog\Options\RangeInterface;

class Pager extends AbstractHelper
{
    /** @var RangeInterface */
    private $range;

    /** @var float */
    private $pagesCount;

    /** @var string */
    private $route;

    /** @var array */
    private $params;

    /** @var mixed */
    private $pageKey;

    /**
     * @param RangeInterface $range
     * @param string         $route
     * @param mixed          $pageKey
     */
    public function __construct(RangeInterface $range, $route, $pageKey)
    {
        $this->range = $range;
        $this->route = $route;
        $this->pageKey = $pageKey;
    }

    /**
     * {@link render()}
     */
    public function __invoke(\Countable $collection, array $params)
    {
        return $this->render($collection, $params);
    }

    /**
     * @param \Countable $collection
     * @param array      $params
     * @return string
     */
    public function render(\Countable $collection, array $params)
    {
        $this->calculatePagesCountBy($collection);

        if ($this->pagesCount < 2) {
            return '';
        }

        $this->params = $params;

        return $this->toHtml();
    }

    /**
     * @return string
     */
    private function toHtml()
    {
        $paramsNext = $paramsPrev = $this->params;

        $paramsNext[$this->pageKey]++;
        $paramsPrev[$this->pageKey]--;

        $currentPage = $this->params[$this->pageKey];

        $pages = array();
        if ($currentPage > 1) {
            $pages[] = $this->createAnchor($paramsPrev, 'prev');
        }

        if ($currentPage < $this->pagesCount) {
            $pages[] = $this->createAnchor($paramsNext, 'next');
        }

        $html = '';
        if (!empty($pages)) {
            $html = '<ul class="pager">' . PHP_EOL
                . '<li>' . implode('</li>' . PHP_EOL . '<li>', $pages) . '</li>' . PHP_EOL
                . '</ul>';
        }

        return $html;
    }

    /**
     * @param \Countable $collection
     * @return void
     */
    private function calculatePagesCountBy(\Countable $collection)
    {
        $totalCount = count($collection);
        $this->pagesCount = ceil($totalCount / $this->range->getSize());
    }

    /**
     * @param mixed  $param
     * @param string $type
     * @return string
     */
    private function createAnchor($param, $type)
    {
        $url = $this->createUrl($param);
        $text = $type == 'next' ? '&raquo;' : '&laquo;';
        $title = $type == 'next' ? 'Next Page' : 'Previous Page';

        return $this->getRenderer()->anchor($url, $title, $text, $type);
    }

    /**
     * @param mixed $param
     * @return string
     */
    private function createUrl($param)
    {
        return $this->getRenderer()->url($this->route, $param);
    }
}
