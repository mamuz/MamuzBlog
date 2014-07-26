<?php

namespace MamuzBlog\Controller\Plugin;

use Zend\Http\PhpEnvironment\Request as HttpRequest;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\View\Model\ModelInterface;
use Zend\View\Model\ViewModel;

class CreateViewModel extends AbstractPlugin
{
    /**
     * Create ViewModel instance
     * and set terminal mode by HttpRequest
     *
     * @param null|array|\Traversable $variables
     * @param null|array|\Traversable $options
     * @return ModelInterface
     */
    public function __invoke($variables = null, $options = null)
    {
        $viewModel = new ViewModel($variables, $options);
        $request = $this->getController()->getRequest();

        if ($request instanceof HttpRequest) {
            $viewModel->setTerminal($request->isXmlHttpRequest());
        } else {
            $viewModel->setTerminal(true);
        }

        $viewModel->setVariable('isTerminal', $viewModel->terminate());

        return $viewModel;
    }
}
