<?php

namespace MamuzBlogTest\Controller\Plugin;

use MamuzBlog\Controller\Plugin\ViewModelFactory;

class ViewModelFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var ViewModelFactory */
    protected $fixture;

    /** @var \Zend\Mvc\Controller\AbstractController | \Mockery\MockInterface */
    protected $mvcController;

    protected function setUp()
    {
        $controller = \Mockery::mock('Zend\Stdlib\DispatchableInterface');

        $this->fixture = new ViewModelFactory;
        $this->fixture->setController($controller);
    }

    public function testExtendingZendActionController()
    {
        $this->assertInstanceOf('Zend\Mvc\Controller\Plugin\AbstractPlugin', $this->fixture);
    }

    public function testCreate()
    {
        $viewModel = $this->fixture->create();
        $this->assertInstanceOf('Zend\View\Model\ViewModel', $viewModel);
        $this->assertTrue($viewModel->getVariable('isTerminal'));
    }

    public function testCreateWithVariablesAndOptions()
    {
        $variables = array('foo' => 'bar');
        $options = array(1, 3, 4);
        $viewModel = $this->fixture->create($variables, $options);
        $this->assertSame($options, $viewModel->getOptions());
        $this->assertSame($variables['foo'], $viewModel->getVariable('foo'));
    }

    public function testCreateWithHttpRequest()
    {
        $httpRequest = \Mockery::mock('Zend\Http\PhpEnvironment\Request');
        $httpRequest->shouldReceive('isXmlHttpRequest')->andReturn(false);
        $controller = \Mockery::mock('Zend\Mvc\Controller\AbstractController');
        $controller->shouldReceive('getRequest')->andReturn($httpRequest);
        $this->fixture->setController($controller);

        $viewModel = $this->fixture->create();
        $this->assertFalse($viewModel->getVariable('isTerminal'));
    }

    public function testCreateWithXmlHttpRequest()
    {
        $httpRequest = \Mockery::mock('Zend\Http\PhpEnvironment\Request');
        $httpRequest->shouldReceive('isXmlHttpRequest')->andReturn(true);
        $controller = \Mockery::mock('Zend\Mvc\Controller\AbstractController');
        $controller->shouldReceive('getRequest')->andReturn($httpRequest);
        $this->fixture->setController($controller);

        $viewModel = $this->fixture->create();
        $this->assertTrue($viewModel->getVariable('isTerminal'));
    }

    public function testCreateForCollection()
    {
        $collection = array('foo', 'bar');

        $params = \Mockery::mock('Zend\Mvc\Controller\Plugin\Params');
        $params->shouldReceive('__invoke')->andReturn($params);
        $params->shouldReceive('fromRoute')->andReturn($params);

        $controller = \Mockery::mock('Zend\Mvc\Controller\AbstractController');
        $controller->shouldReceive('getRequest')->andReturn(null);
        $controller->shouldReceive('params')->andReturn($params);
        $this->fixture->setController($controller);

        $viewModel = $this->fixture->createFor($collection);
        $this->assertSame($collection, $viewModel->getVariable('collection'));
        $this->assertSame($params, $viewModel->getVariable('routeParams'));
    }
}
