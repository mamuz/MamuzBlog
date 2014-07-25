<?php

namespace MamuzBlog\Controller;

use MamuzBlog\Crypt\AdapterInterface;
use MamuzBlog\Feature\PostQueryInterface;
use Zend\Http\PhpEnvironment\Request as HttpRequest;
use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ModelInterface;
use Zend\View\Model\ViewModel;

class PostQueryController extends AbstractActionController
{
    /** @var PostQueryInterface */
    private $queryService;

    /** @var AdapterInterface */
    private $cryptEngine;

    /**
     * @param PostQueryInterface $queryService
     * @param AdapterInterface   $cryptEngine
     */
    public function __construct(
        PostQueryInterface $queryService,
        AdapterInterface $cryptEngine
    ) {
        $this->queryService = $queryService;
        $this->cryptEngine = $cryptEngine;
    }

    /**
     * Active post entries retrieval
     *
     * @return ModelInterface
     */
    public function activePostsAction()
    {
        $currentPage = $this->params()->fromRoute('page', 1);
        $this->queryService->setCurrentPage($currentPage);

        if ($tag = $this->params()->fromRoute('tag')) {
            $collection = $this->queryService->findActivePostsByTag($tag);
        } else {
            $collection = $this->queryService->findActivePosts();
        }

        return $this->createViewModel(
            array(
                'collection'  => $collection,
                'routeParams' => $this->params()->fromRoute(),
            )
        );
    }

    /**
     * Active post entry retrieval
     *
     * @return ModelInterface|null
     */
    public function activePostAction()
    {
        $encryptedId = $this->params()->fromRoute('id');
        if ($decryptedId = $this->cryptEngine->decrypt($encryptedId)) {
            $post = $this->queryService->findActivePostById($decryptedId);
        }

        if (!isset($post)) {
            return $this->nullResponse();
        }

        return $this->createViewModel(array('post' => $post));
    }

    /**
     * Set 404 status code to response
     *
     * @return null
     */
    private function nullResponse()
    {
        /** @var Response $response */
        $response = $this->getResponse();
        $response->setStatusCode(Response::STATUS_CODE_404);

        return null;
    }

    /**
     * Create ViewModel instance
     * and set terminal mode by HttpRequest
     *
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
