<?php

namespace MamuzBlogTest\Controller;

use MamuzBlog\Controller\QueryController;
use MamuzBlogTest\Bootstrap;
use Zend\Console\Request as ConsoleRequest;
use Zend\Http\Headers;
use Zend\Http\PhpEnvironment\Request;
use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Zend\Mvc\Router\RouteMatch;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;

class QueryControllerTest extends \PHPUnit_Framework_TestCase
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

    /** @var Headers */
    protected $xhrHeaders;

    /** @var \MamuzBlog\Feature\QueryInterface | \Mockery\MockInterface */
    protected $queryInterface;

    /** @var \MamuzBlog\Crypt\AdapterInterface | \Mockery\MockInterface */
    protected $cryptEngine;

    /** @var \Zend\Mvc\Controller\Plugin\Params | \Mockery\MockInterface */
    protected $params;

    protected function setUp()
    {
        $this->cryptEngine = \Mockery::mock('MamuzBlog\Crypt\AdapterInterface');
        $this->queryInterface = \Mockery::mock('MamuzBlog\Feature\QueryInterface');

        $this->xhrHeaders = new Headers;
        $this->xhrHeaders->addHeaderLine('X_REQUESTED_WITH', 'XMLHttpRequest');

        $this->fixture = new QueryController($this->queryInterface, $this->cryptEngine);
        $this->request = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'index'));
        $this->event = new MvcEvent();
        $router = HttpRouter::factory(array());

        $this->params = \Mockery::mock('Zend\Mvc\Controller\Plugin\Params');
        $this->params->shouldReceive('__invoke')->andReturn($this->params);
        $pluginManager = \Mockery::mock('Zend\Mvc\Controller\PluginManager')->shouldIgnoreMissing();
        $pluginManager->shouldReceive('get')->with('params', null)->andReturn($this->params);

        $this->fixture->setPluginManager($pluginManager);
        $this->event->setRouter($router);
        $this->event->setRouteMatch($this->routeMatch);
        $this->fixture->setEvent($this->event);
    }

    public function testExtendingZendActionController()
    {
        $this->assertInstanceOf('Zend\Mvc\Controller\AbstractActionController', $this->fixture);
    }

    public function testActivePostsWithoutTagCanBeAccessed()
    {
        $page = 'foo';
        $params = array(2, 1);
        $posts = array(1, 2);

        $this->params->shouldReceive('fromRoute')->with('page', 1)->andReturn($page);
        $this->params->shouldReceive('fromRoute')->with('tag')->andReturn(null);
        $this->params->shouldReceive('fromRoute')->andReturn($params);

        $this->queryInterface->shouldReceive('setCurrentPage')->with($page);
        $this->queryInterface->shouldReceive('findActivePosts')->andReturn($posts);

        $this->routeMatch->setParam('action', 'activePosts');

        // HTTP
        $result = $this->fixture->dispatch($this->request);
        $response = $this->fixture->getResponse();

        $this->assertInstanceOf('Zend\View\Model\ModelInterface', $result);
        $this->assertEquals(200, $response->getStatusCode());

        $viewVariables = $result->getVariables();
        $this->assertSame($params, $viewVariables['routeParams']);
        $this->assertSame($posts, $viewVariables['collection']);
        $this->assertFalse($viewVariables['isTerminal']);

        // XHR
        $this->request->setHeaders($this->xhrHeaders);
        $result = $this->fixture->dispatch($this->request);
        $response = $this->fixture->getResponse();

        $this->assertInstanceOf('Zend\View\Model\ModelInterface', $result);
        $this->assertEquals(200, $response->getStatusCode());

        $viewVariables = $result->getVariables();
        $this->assertSame($params, $viewVariables['routeParams']);
        $this->assertSame($posts, $viewVariables['collection']);
        $this->assertTrue($viewVariables['isTerminal']);

        // CLI
        $this->request = new ConsoleRequest;
        $result = $this->fixture->dispatch($this->request);
        $response = $this->fixture->getResponse();

        $this->assertInstanceOf('Zend\View\Model\ModelInterface', $result);
        $this->assertEquals(200, $response->getStatusCode());

        $viewVariables = $result->getVariables();
        $this->assertSame($params, $viewVariables['routeParams']);
        $this->assertSame($posts, $viewVariables['collection']);
        $this->assertTrue($viewVariables['isTerminal']);
    }

    public function testActivePostsWithTagCanBeAccessed()
    {
        $page = 'foo';
        $tag = 'bar';
        $params = array(2, 1);
        $posts = array(1, 2);

        $this->params->shouldReceive('fromRoute')->with('page', 1)->andReturn($page);
        $this->params->shouldReceive('fromRoute')->with('tag')->andReturn($tag);
        $this->params->shouldReceive('fromRoute')->andReturn($params);

        $this->queryInterface->shouldReceive('setCurrentPage')->with($page);
        $this->queryInterface->shouldReceive('findActivePostsByTag')->with($tag)->andReturn($posts);
        $this->routeMatch->setParam('action', 'activePosts');

        $result = $this->fixture->dispatch($this->request);
        $response = $this->fixture->getResponse();

        $this->assertInstanceOf('Zend\View\Model\ModelInterface', $result);
        $this->assertEquals(200, $response->getStatusCode());

        $viewVariables = $result->getVariables();
        $this->assertSame($params, $viewVariables['routeParams']);
        $this->assertSame($posts, $viewVariables['collection']);
        $this->assertFalse($viewVariables['isTerminal']);
    }

    public function testActivePostWithPostCanBeAccessed()
    {
        $id = 'foo';
        $post = 'bar';

        $this->params->shouldReceive('fromRoute')->with('id')->andReturn($id);
        $this->cryptEngine->shouldReceive('decrypt')->with($id)->andReturn($id);
        $this->queryInterface->shouldReceive('findActivePostById')->with($id)->andReturn($post);

        $this->routeMatch->setParam('action', 'activePost');

        // HTTP
        $result = $this->fixture->dispatch($this->request);
        $response = $this->fixture->getResponse();

        $this->assertInstanceOf('Zend\View\Model\ModelInterface', $result);
        $this->assertEquals(200, $response->getStatusCode());

        $viewVariables = $result->getVariables();
        $this->assertSame($post, $viewVariables['post']);
        $this->assertFalse($viewVariables['isTerminal']);

        // XHR
        $this->request->setHeaders($this->xhrHeaders);
        $result = $this->fixture->dispatch($this->request);
        $response = $this->fixture->getResponse();

        $this->assertInstanceOf('Zend\View\Model\ModelInterface', $result);
        $this->assertEquals(200, $response->getStatusCode());

        $viewVariables = $result->getVariables();
        $this->assertSame($post, $viewVariables['post']);
        $this->assertTrue($viewVariables['isTerminal']);

        // CLI
        $this->request = new ConsoleRequest;
        $result = $this->fixture->dispatch($this->request);
        $response = $this->fixture->getResponse();

        $this->assertInstanceOf('Zend\View\Model\ModelInterface', $result);
        $this->assertEquals(200, $response->getStatusCode());

        $viewVariables = $result->getVariables();
        $this->assertSame($post, $viewVariables['post']);
        $this->assertTrue($viewVariables['isTerminal']);
    }

    public function testActivePostWithoutPostCanBeAccessed()
    {
        $id = 'foo';

        $this->params->shouldReceive('fromRoute')->with('id')->andReturn($id);
        $this->cryptEngine->shouldReceive('decrypt')->with($id)->andReturn($id);
        $this->queryInterface->shouldReceive('findActivePostById')->with($id)->andReturn(null);

        $this->routeMatch->setParam('action', 'activePost');
        $result = $this->fixture->dispatch($this->request);
        $response = $this->fixture->getResponse();

        $this->assertNull($result);
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testActivePostWithNullDecryptionCanBeAccessed()
    {
        $id = 'foo';

        $this->params->shouldReceive('fromRoute')->with('id')->andReturn($id);
        $this->cryptEngine->shouldReceive('decrypt')->with($id)->andReturn(null);

        $this->routeMatch->setParam('action', 'activePost');
        $result = $this->fixture->dispatch($this->request);
        $response = $this->fixture->getResponse();

        $this->assertNull($result);
        $this->assertEquals(404, $response->getStatusCode());
    }
}
