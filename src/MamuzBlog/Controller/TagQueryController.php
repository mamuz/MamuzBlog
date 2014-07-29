<?php

namespace MamuzBlog\Controller;

use MamuzBlog\Feature\TagQueryInterface;
use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ModelInterface;

/**
 * @method \MamuzBlog\Controller\Plugin\ViewModelFactory viewModelFactory()
 * @method \MamuzBlog\Controller\Plugin\RouteParam routeParam()
 */
class TagQueryController extends AbstractActionController
{
    /** @var TagQueryInterface */
    private $queryService;

    /**
     * @param TagQueryInterface $queryService
     */
    public function __construct(TagQueryInterface $queryService)
    {
        $this->queryService = $queryService;
    }

    /**
     * Tag list retrieval
     *
     * @return ModelInterface
     */
    public function listAction()
    {
        $this->routeParam()->mapPageTo($this->queryService);
        $collection = $this->queryService->findUsedTags();

        return $this->viewModelFactory()->createFor($collection);
    }
}
