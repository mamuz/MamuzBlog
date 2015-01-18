<?php

namespace MamuzBlogTest;

use MamuzBlog\Module;

class ModuleTest extends \PHPUnit_Framework_TestCase
{
    /** @var Module */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new Module;
    }

    public function testImplementingFeatures()
    {
        $this->assertInstanceOf('Zend\ModuleManager\Feature\AutoloaderProviderInterface', $this->fixture);
        $this->assertInstanceOf('Zend\ModuleManager\Feature\ConfigProviderInterface', $this->fixture);
        $this->assertInstanceOf('Zend\ModuleManager\Feature\InitProviderInterface', $this->fixture);
    }

    public function testConfigRetrieval()
    {
        $expected = include __DIR__ . '/../../config/module.config.php';
        $this->assertSame($expected, $this->fixture->getConfig());
    }

    public function testAutoloaderConfigRetrieval()
    {
        $expected = array(
            'Zend\Loader\ClassMapAutoloader',
            'Zend\Loader\StandardAutoloader',
        );

        $this->assertSame($expected, array_keys($this->fixture->getAutoloaderConfig()));
    }

    public function testLoadingModules()
    {
        $moduleManager = \Mockery::mock('Zend\ModuleManager\ModuleManagerInterface');
        $moduleManager->shouldReceive('loadModule')->with('DoctrineModule');
        $moduleManager->shouldReceive('loadModule')->with('DoctrineORMModule');
        $moduleManager->shouldReceive('loadModule')->with('TwbBundle');
        $moduleManager->shouldReceive('loadModule')->with('MaglMarkdown');

        $this->fixture->init($moduleManager);
    }

    public function testAddingServiceManager()
    {
        $serviceListener = \Mockery::mock('Zend\ModuleManager\Listener\ServiceListenerInterface');
        $serviceListener->shouldReceive('addServiceManager')->with(
            'MamuzBlog\DomainManager',
            'blog_domain',
            'MamuzBlog\DomainManager\ProviderInterface',
            'getBlogDomainConfig'
        );
        $serviceLocator = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $serviceLocator->shouldReceive('get')->with('ServiceListener')->andReturn($serviceListener);
        $event = \Mockery::mock('Zend\EventManager\EventInterface');
        $event->shouldReceive('getParam')->with('ServiceManager')->andReturn($serviceLocator);
        $moduleManager = \Mockery::mock('Zend\ModuleManager\ModuleManager');
        $moduleManager->shouldReceive('loadModule');
        $moduleManager->shouldReceive('getEvent')->andReturn($event);

        $this->fixture->init($moduleManager);
    }
}
