<?php

namespace MamuzBlog\Controller;

use MamuzBlog\Feature\TagQueryInterface;
use Zend\Http\PhpEnvironment\Request as HttpRequest;
use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ModelInterface;
use Zend\View\Model\ViewModel;

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

    /**
     * @todo extract me to controller plugin
     *       Create ViewModel instance
     *       and set terminal mode by HttpRequest
     * @param null|array|\Traversable $variables
     * @param null|array|\Traversable $options
     * @return ModelInterface
     */
    private function createViewModel($variables = null, $options = null)
    {
        $viewModel = new ViewModel($variables, $options);
        $request = $this->getRequest();

        if ($request instanceof HttpRequest) {
            $viewModel->setTerminal($request->isXmlHttpRequest());
        } else {
            $viewModel->setTerminal(true);
        }

        $viewModel->setVariable('isTerminal', $viewModel->terminate());

        return $viewModel;
    }
}
