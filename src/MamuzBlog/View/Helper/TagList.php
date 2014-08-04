<?php

namespace MamuzBlog\View\Helper;

use MamuzBlog\Feature\TagQueryInterface;
use Zend\Mvc\MvcEvent;

class TagList extends AbstractHelper
{
    /** @var TagQueryInterface */
    private $queryService;

    /** @var MvcEvent */
    private $event;

    /**
     * @param MvcEvent          $event
     * @param TagQueryInterface $queryService
     */
    public function __construct(MvcEvent $event, TagQueryInterface $queryService)
    {
        $this->event = $event;
        $this->queryService = $queryService;
    }

    /**
     * {@link render()}
     */
    public function __invoke()
    {
        return $this->render();
    }

    /**
     * @return string
     */
    public function render()
    {
        return $this->getRenderer()->partial(
            'mamuz-blog/tag-query/items',
            array(
                'collection' => $this->queryService->findUsedTags(),
                'currentTag' => $this->event->getRouteMatch()->getParam('tag', false),
            )
        );
    }
}
