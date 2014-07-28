<?php

namespace MamuzBlogTest\Controller;

use MamuzBlog\Controller\TagQueryControllerFactory;

class TagQueryControllerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var TagQueryControllerFactory */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new TagQueryControllerFactory;
    }

    public function testImplementingFactoryInterface()
    {
        $this->assertInstanceOf('Zend\ServiceManager\FactoryInterface', $this->fixture);
    }

    public function testCreation()
    {
        $queryInterface = \Mockery::mock('MamuzBlog\Feature\TagQueryInterface');
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $sm->shouldReceive('getServiceLocator')->andReturn($sm);
        $sm->shouldReceive('get')->with('MamuzBlog\DomainManager')->andReturn($sm);
        $sm->shouldReceive('get')->with('MamuzBlog\Service\TagQuery')->andReturn($queryInterface);

        $controller = $this->fixture->createService($sm);

        $this->assertInstanceOf('Zend\Mvc\Controller\AbstractController', $controller);
    }

    public function testCreationWithServiceLocatorAwareness()
    {
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');

        $sl = \Mockery::mock('Zend\ServiceManager\AbstractPluginManager');
        $sl->shouldReceive('getServiceLocator')->andReturn($sm);

        $queryInterface = \Mockery::mock('MamuzBlog\Feature\TagQueryInterface');
        $sm->shouldReceive('getServiceLocator')->andReturn($sm);
        $sm->shouldReceive('get')->with('MamuzBlog\DomainManager')->andReturn($sm);
        $sm->shouldReceive('get')->with('MamuzBlog\Service\TagQuery')->andReturn($queryInterface);

        $controller = $this->fixture->createService($sl);

        $this->assertInstanceOf('Zend\Mvc\Controller\AbstractController', $controller);
    }
}
