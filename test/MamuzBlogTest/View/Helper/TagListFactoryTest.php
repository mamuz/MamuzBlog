<?php

namespace MamuzBlogTest\View\Helper;

use MamuzBlog\View\Helper\TagListFactory;

class TagListFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var TagListFactory */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new TagListFactory;
    }

    public function testImplementingFactoryInterface()
    {
        $this->assertInstanceOf('Zend\ServiceManager\FactoryInterface', $this->fixture);
    }

    public function testCreation()
    {
        $mvcEvent = \Mockery::mock('Zend\Mvc\MvcEvent');
        $application = \Mockery::mock('Zend\Mvc\Application');
        $application->shouldReceive('getMvcEvent')->andReturn($mvcEvent);
        $tagQueryService = \Mockery::mock('MamuzBlog\Feature\TagQueryInterface');
        $domainManager = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $domainManager->shouldReceive('get')->with('MamuzBlog\Service\TagQuery')->andReturn($tagQueryService);
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $sm->shouldReceive('get')->with('MamuzBlog\DomainManager')->andReturn($domainManager);
        $sm->shouldReceive('get')->with('Application')->andReturn($application);

        $helper = $this->fixture->createService($sm);

        $this->assertInstanceOf('Zend\View\Helper\HelperInterface', $helper);
    }

    public function testCreationWithServiceLocatorAwareness()
    {
        $mvcEvent = \Mockery::mock('Zend\Mvc\MvcEvent');
        $application = \Mockery::mock('Zend\Mvc\Application');
        $application->shouldReceive('getMvcEvent')->andReturn($mvcEvent);
        $tagQueryService = \Mockery::mock('MamuzBlog\Feature\TagQueryInterface');
        $domainManager = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $domainManager->shouldReceive('get')->with('MamuzBlog\Service\TagQuery')->andReturn($tagQueryService);
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $sm->shouldReceive('get')->with('MamuzBlog\DomainManager')->andReturn($domainManager);
        $sm->shouldReceive('get')->with('Application')->andReturn($application);

        $sl = \Mockery::mock('Zend\ServiceManager\AbstractPluginManager');
        $sl->shouldReceive('getServiceLocator')->andReturn($sm);

        $config = array('mamuz-blog' => array('pagination' => array('range' => array('tag' => 3))));
        $sm->shouldReceive('get')->with('Config')->andReturn($config);

        $helper = $this->fixture->createService($sl);

        $this->assertInstanceOf('Zend\View\Helper\HelperInterface', $helper);
    }
}
