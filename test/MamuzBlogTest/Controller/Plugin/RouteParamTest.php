<?php

namespace MamuzBlogTest\Controller\Plugin;

use MamuzBlog\Controller\Plugin\RouteParam;

class RouteParamTest extends \PHPUnit_Framework_TestCase
{
    /** @var RouteParam */
    protected $fixture;

    /** @var \MamuzBlog\Feature\Pageable | \Mockery\MockInterface */
    protected $pageableInterface;

    /** @var \Zend\Mvc\Controller\AbstractController | \Mockery\MockInterface */
    protected $mvcController;

    protected function setUp()
    {
        $this->pageableInterface = \Mockery::mock('MamuzBlog\Feature\Pageable');
        $this->fixture = new RouteParam;
    }

    public function testExtendingZendActionController()
    {
        $this->assertInstanceOf('Zend\Mvc\Controller\Plugin\AbstractPlugin', $this->fixture);
    }

    public function testMapPageToPageableInterfaceWithoutMvcController()
    {
        $controller = \Mockery::mock('Zend\Stdlib\DispatchableInterface');
        $this->fixture->setController($controller);
        $this->pageableInterface->shouldReceive('setCurrentPage')->with(1)->once();

        $this->fixture->mapPageTo($this->pageableInterface);
    }

    public function testMapPageToPageableInterface()
    {
        $page = 4;

        $params = \Mockery::mock('Zend\Mvc\Controller\Plugin\Params');
        $params->shouldReceive('__invoke')->andReturn($params);
        $params->shouldReceive('fromRoute')->with('page', 1)->andReturn($page);

        $this->mvcController = \Mockery::mock('Zend\Mvc\Controller\AbstractController');
        $this->mvcController->shouldReceive('params')->andReturn($params);

        $this->fixture->setController($this->mvcController);
        $this->pageableInterface->shouldReceive('setCurrentPage')->with($page)->once();

        $this->fixture->mapPageTo($this->pageableInterface);
    }
}
