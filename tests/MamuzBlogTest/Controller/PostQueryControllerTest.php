<?php

namespace MamuzBlogTest\Controller;

use MamuzBlog\Controller\PostQueryController;
use Zend\Http\PhpEnvironment\Request;
use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Zend\Mvc\Router\RouteMatch;

class PostQueryControllerTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Zend\Mvc\Controller\AbstractActionController */
    protected $fixture;

    /** @var Request */
    protected $request;

    /** @var Response */
    protected $response;

    /** @var RouteMatch */
    protected $routeMatch;

    /** @var MvcEvent */
    protected $event;

    /** @var \MamuzBlog\Feature\PostQueryInterface | \Mockery\MockInterface */
    protected $queryInterface;

    /** @var \MamuzBlog\Crypt\AdapterInterface | \Mockery\MockInterface */
    protected $cryptEngine;

    /** @var \Zend\Mvc\Controller\Plugin\Params | \Mockery\MockInterface */
    protected $params;

    /** @var \MamuzBlog\Controller\Plugin\ViewModelFactory | \Mockery\MockInterface */
    protected $viewModelFactory;

    /** @var \MamuzBlog\Controller\Plugin\RouteParam | \Mockery\MockInterface */
    protected $routeParam;

    /** @var \Zend\View\Model\ModelInterface | \Mockery\MockInterface */
    protected $viewModel;

    protected function setUp()
    {
        $this->viewModel = \Mockery::mock('Zend\View\Model\ModelInterface');
        $this->cryptEngine = \Mockery::mock('MamuzBlog\Crypt\AdapterInterface');
        $this->queryInterface = \Mockery::mock('MamuzBlog\Feature\PostQueryInterface');
        $this->routeParam = \Mockery::mock('Zend\View\Model\RouteParam');

        $this->fixture = new PostQueryController($this->queryInterface, $this->cryptEngine);
        $this->request = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'index'));
        $this->event = new MvcEvent();
        $router = HttpRouter::factory();

        $this->viewModelFactory = \Mockery::mock('MamuzBlog\Controller\Plugin\ViewModelFactory');
        $this->params = \Mockery::mock('Zend\Mvc\Controller\Plugin\Params');
        $this->params->shouldReceive('__invoke')->andReturn($this->params);
        $pluginManager = \Mockery::mock('Zend\Mvc\Controller\PluginManager')->shouldIgnoreMissing();
        $pluginManager->shouldReceive('get')->with('params', null)->andReturn($this->params);
        $pluginManager->shouldReceive('get')->with('viewModelFactory', null)->andReturn($this->viewModelFactory);
        $pluginManager->shouldReceive('get')->with('routeParam', null)->andReturn($this->routeParam);

        $this->fixture->setPluginManager($pluginManager);
        $this->event->setRouter($router);
        $this->event->setRouteMatch($this->routeMatch);
        $this->fixture->setEvent($this->event);
    }

    public function testExtendingZendActionController()
    {
        $this->assertInstanceOf('Zend\Mvc\Controller\AbstractActionController', $this->fixture);
    }

    public function testPublishedPostsWithoutTagCanBeAccessed()
    {
        $posts = new \ArrayObject;

        $this->routeParam->shouldReceive('mapPageTo')->with($this->queryInterface);
        $this->params->shouldReceive('fromRoute')->with('tag')->andReturn(null);
        $this->queryInterface->shouldReceive('findPublishedPosts')->andReturn($posts);
        $this->routeMatch->setParam('action', 'publishedPosts');

        $this->viewModelFactory
            ->shouldReceive('createFor')
            ->with($posts)
            ->andReturn($this->viewModel);

        $result = $this->fixture->dispatch($this->request);
        $response = $this->fixture->getResponse();

        $this->assertSame($this->viewModel, $result);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testPublishedPostsWithTagCanBeAccessed()
    {
        $tag = 'bar';
        $posts = new \ArrayObject;

        $this->routeParam->shouldReceive('mapPageTo')->with($this->queryInterface);
        $this->params->shouldReceive('fromRoute')->with('tag')->andReturn($tag);
        $this->queryInterface->shouldReceive('findPublishedPostsByTag')->with($tag)->andReturn($posts);
        $this->routeMatch->setParam('action', 'publishedPosts');

        $this->viewModelFactory
            ->shouldReceive('createFor')
            ->with($posts)
            ->andReturn($this->viewModel);

        $result = $this->fixture->dispatch($this->request);
        $response = $this->fixture->getResponse();

        $this->assertSame($this->viewModel, $result);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testPublishedPostWithoutPostCanBeAccessed()
    {
        $id = 'foo';

        $this->params->shouldReceive('fromRoute')->with('id')->andReturn($id);
        $this->cryptEngine->shouldReceive('decrypt')->with($id)->andReturn($id);
        $this->queryInterface->shouldReceive('findPublishedPostById')->with($id)->andReturn(null);

        $this->routeMatch->setParam('action', 'publishedPost');
        $result = $this->fixture->dispatch($this->request);
        $response = $this->fixture->getResponse();

        $this->assertNull($result);
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testPublishedPostWithNullDecryptionCanBeAccessed()
    {
        $id = 'foo';

        $this->params->shouldReceive('fromRoute')->with('id')->andReturn($id);
        $this->cryptEngine->shouldReceive('decrypt')->with($id)->andReturn(null);

        $this->routeMatch->setParam('action', 'publishedPost');
        $result = $this->fixture->dispatch($this->request);
        $response = $this->fixture->getResponse();

        $this->assertNull($result);
        $this->assertEquals(404, $response->getStatusCode());
    }
}
