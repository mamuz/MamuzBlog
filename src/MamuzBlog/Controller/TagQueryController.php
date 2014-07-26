<?php

namespace MamuzBlog\Controller;

use MamuzBlog\Feature\TagQueryInterface;
use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ModelInterface;

/**
 * @method \MamuzBlog\Controller\Plugin\CreateViewModel createViewModel($variables = null, $options = null)
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
        $currentPage = $this->params()->fromRoute('page', 1);
        $this->queryService->setCurrentPage($currentPage);

        return $this->createViewModel(
            array(
                'collection'  => $this->queryService->findTags(),
                'routeParams' => $this->params()->fromRoute(),
            )
        );
    }
}
