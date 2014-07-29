<?php

namespace MamuzBlogTest\Controller;

use MamuzBlog\Controller\TagQueryController;
use Zend\Http\PhpEnvironment\Request;
use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Zend\Mvc\Router\RouteMatch;
use Zend\ServiceManager\ServiceManager;

class TagQueryControllerTest extends \PHPUnit_Framework_TestCase
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

    /** @var \MamuzBlog\Feature\TagQueryInterface | \Mockery\MockInterface */
    protected $queryInterface;

    /** @var \MamuzBlog\Controller\Plugin\ViewModelFactory | \Mockery\MockInterface */
    protected $viewModelFactory;

    /** @var \MamuzBlog\Controller\Plugin\RouteParam | \Mockery\MockInterface */
    protected $routeParam;

    /** @var \Zend\View\Model\ModelInterface | \Mockery\MockInterface */
    protected $viewModel;

    protected function setUp()
    {
        $this->viewModel = \Mockery::mock('Zend\View\Model\ModelInterface');
        $this->queryInterface = \Mockery::mock('MamuzBlog\Feature\TagQueryInterface');
        $this->routeParam = \Mockery::mock('Zend\View\Model\RouteParam');

        $this->fixture = new TagQueryController($this->queryInterface);
        $this->request = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'index'));
        $this->event = new MvcEvent();
        $router = HttpRouter::factory();

        $this->viewModelFactory = \Mockery::mock('MamuzBlog\Controller\Plugin\ViewModelFactory');
        $pluginManager = \Mockery::mock('Zend\Mvc\Controller\PluginManager')->shouldIgnoreMissing();
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

    public function testListingTags()
    {
        $tags = new \ArrayObject;

        $this->routeParam->shouldReceive('mapPageTo')->with($this->queryInterface);
        $this->queryInterface->shouldReceive('findUsedTags')->andReturn($tags);
        $this->routeMatch->setParam('action', 'list');

        $this->viewModelFactory
            ->shouldReceive('createFor')
            ->with($tags)
            ->andReturn($this->viewModel);

        $result = $this->fixture->dispatch($this->request);
        $response = $this->fixture->getResponse();

        $this->assertSame($this->viewModel, $result);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
