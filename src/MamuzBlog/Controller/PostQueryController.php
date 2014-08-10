<?php

namespace MamuzBlog\Controller;

use MamuzBlog\Crypt\AdapterInterface;
use MamuzBlog\Feature\PostQueryInterface;
use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ModelInterface;

/**
 * @method \MamuzBlog\Controller\Plugin\ViewModelFactory viewModelFactory()
 * @method \MamuzBlog\Controller\Plugin\RouteParam routeParam()
 */
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
     * Published post entries retrieval
     *
     * @return ModelInterface
     */
    public function publishedPostsAction()
    {
        $this->routeParam()->mapPageTo($this->queryService);

        if ($tag = $this->params()->fromRoute('tag')) {
            $collection = $this->queryService->findPublishedPostsByTag($tag);
        } else {
            $collection = $this->queryService->findPublishedPosts();
        }

        return $this->viewModelFactory()->createFor($collection);
    }

    /**
     * Published post entry retrieval
     *
     * @return ModelInterface|null
     */
    public function publishedPostAction()
    {
        $encryptedId = $this->params()->fromRoute('id');
        if ($decryptedId = $this->cryptEngine->decrypt($encryptedId)) {
            $post = $this->queryService->findPublishedPostById($decryptedId);
        }

        if (!isset($post)) {
            return $this->nullResponse();
        }

        return $this->viewModelFactory()->create(array('post' => $post));
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
}
