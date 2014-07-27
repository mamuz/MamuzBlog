<?php

namespace MamuzBlog\Controller\Plugin;

use Zend\Http\PhpEnvironment\Request as HttpRequest;
use Zend\View\Model\ModelInterface;
use Zend\View\Model\ViewModel;

class ViewModelFactory extends AbstractPlugin
{
    /**
     * Create ViewModel instance
     * and set terminal mode by HttpRequest
     *
     * @param null|array|\Traversable $variables
     * @param null|array|\Traversable $options
     * @return ModelInterface
     */
    public function create($variables = null, $options = null)
    {
        $viewModel = new ViewModel($variables, $options);
        $viewModel->setTerminal($this->isTerminal());
        $viewModel->setVariable('isTerminal', $viewModel->terminate());

        return $viewModel;
    }

    /**
     * @param array|\Traversable $collection
     * @return ModelInterface
     */
    public function createFor($collection)
    {
        return $this->create(
            array(
                'collection'  => $collection,
                'routeParams' => $this->getMvcController()->params()->fromRoute(),
            )
        );
    }

    /**
     * @return bool
     */
    private function isTerminal()
    {
        if ($httpRequest = $this->getHttpRequest()) {
            return $httpRequest->isXmlHttpRequest();
        }

        return true;
    }

    /**
     * @return HttpRequest|null
     */
    private function getHttpRequest()
    {
        if ($controller = $this->getMvcController()) {
            $request = $controller->getRequest();
            if ($request instanceof HttpRequest) {
                return $request;
            }
        }

        return null;
    }
}
