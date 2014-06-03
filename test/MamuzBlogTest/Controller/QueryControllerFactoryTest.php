<?php

namespace MamuzBlogTest\Controller;

use MamuzBlog\Controller\QueryControllerFactory;

class QueryControllerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var QueryControllerFactory */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new QueryControllerFactory;
    }

    public function testImplementingFactoryInterface()
    {
        $this->assertInstanceOf('Zend\ServiceManager\FactoryInterface', $this->fixture);
    }

    public function testCreation()
    {
        $cryptEngine = \Mockery::mock('MamuzBlog\Crypt\AdapterInterface');
        $queryInterface = \Mockery::mock('MamuzBlog\Feature\QueryInterface');
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $sm->shouldReceive('getServiceLocator')->andReturn($sm);
        $sm->shouldReceive('get')->with('MamuzBlog\DomainManager')->andReturn($sm);
        $sm->shouldReceive('get')->with('MamuzBlog\Service\Query')->andReturn($queryInterface);
        $sm->shouldReceive('get')->with('MamuzBlog\Crypt\HashIdAdapter')->andReturn($cryptEngine);

        $controller = $this->fixture->createService($sm);

        $this->assertInstanceOf('Zend\Mvc\Controller\AbstractController', $controller);
    }

    public function testCreationWithServiceLocatorAwareness()
    {
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');

        $sl = \Mockery::mock('Zend\ServiceManager\AbstractPluginManager');
        $sl->shouldReceive('getServiceLocator')->andReturn($sm);

        $cryptEngine = \Mockery::mock('MamuzBlog\Crypt\AdapterInterface');
        $queryInterface = \Mockery::mock('MamuzBlog\Feature\QueryInterface');
        $sm->shouldReceive('getServiceLocator')->andReturn($sm);
        $sm->shouldReceive('get')->with('MamuzBlog\DomainManager')->andReturn($sm);
        $sm->shouldReceive('get')->with('MamuzBlog\Service\Query')->andReturn($queryInterface);
        $sm->shouldReceive('get')->with('MamuzBlog\Crypt\HashIdAdapter')->andReturn($cryptEngine);

        $controller = $this->fixture->createService($sl);

        $this->assertInstanceOf('Zend\Mvc\Controller\AbstractController', $controller);
    }
}
