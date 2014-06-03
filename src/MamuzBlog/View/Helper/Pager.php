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
            $url = $this->getView()->url($route, $paramsPrev);
            $this->html .= '<a class="prev" href="' . $url . '">&laquo;</a>&nbsp;' . PHP_EOL;
        }

        if ($currentPage < $pagesCount) {
            $url = $this->getView()->url($route, $paramsNext);
            $this->html .= '<a class="next" href="' . $url . '">&raquo;</a>' . PHP_EOL;
        }

        return $this->html;
    }
}
