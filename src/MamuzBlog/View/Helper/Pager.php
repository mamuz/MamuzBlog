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

        $html = '';
        if ($currentPage > 1) {
            $html .= $this->buildAnchor($paramsPrev, 'prev');
        }

        if ($currentPage < $this->pagesCount) {
            $html .= $this->buildAnchor($paramsNext, 'next');
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
    private function buildAnchor($param, $type)
    {
        $url = $this->buildUrl($param);
        $text = $type == 'next' ? '&raquo;' : '&laquo;';

        return '<a class="' . $type . '" href="' . $url . '">' . $text . '</a>' . PHP_EOL;
    }

    /**
     * @param mixed $param
     * @return string
     */
    private function buildUrl($param)
    {
        return $this->getRenderer()->url($this->route, $param);
    }
}
