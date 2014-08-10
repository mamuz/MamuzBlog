<?php

namespace MamuzBlogTest\View\Helper;

use MamuzBlog\View\Helper\HashIdFactory;

class HashIdFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var HashIdFactory */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new HashIdFactory;
    }

    public function testImplementingFactoryInterface()
    {
        $this->assertInstanceOf('Zend\ServiceManager\FactoryInterface', $this->fixture);
    }

    public function testCreation()
    {
        $adapter = \Mockery::mock('MamuzBlog\Crypt\AdapterInterface');
        $domainManager = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $domainManager->shouldReceive('get')->with('MamuzBlog\Crypt\HashIdAdapter')->andReturn($adapter);
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $sm->shouldReceive('get')->with('MamuzBlog\DomainManager')->andReturn($domainManager);

        $helper = $this->fixture->createService($sm);

        $this->assertInstanceOf('Zend\View\Helper\HelperInterface', $helper);
    }

    public function testCreationWithServiceLocatorAwareness()
    {
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');

        $sl = \Mockery::mock('Zend\ServiceManager\AbstractPluginManager');
        $sl->shouldReceive('getServiceLocator')->andReturn($sm);

        $adapter = \Mockery::mock('MamuzBlog\Crypt\AdapterInterface');
        $domainManager = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $domainManager->shouldReceive('get')->with('MamuzBlog\Crypt\HashIdAdapter')->andReturn($adapter);
        $sm->shouldReceive('get')->with('MamuzBlog\DomainManager')->andReturn($domainManager);

        $helper = $this->fixture->createService($sl);

        $this->assertInstanceOf('Zend\View\Helper\HelperInterface', $helper);
    }
}
