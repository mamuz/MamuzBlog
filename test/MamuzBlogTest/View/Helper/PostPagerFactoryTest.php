<?php

namespace MamuzBlogTest\View\Helper;

use MamuzBlog\View\Helper\PostPagerFactory;

class PagerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var PostPagerFactory */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new PostPagerFactory;
    }

    public function testImplementingFactoryInterface()
    {
        $this->assertInstanceOf('Zend\ServiceManager\FactoryInterface', $this->fixture);
    }

    public function testCreation()
    {
        $config = array('mamuz-blog' => array('pagination' => array('range' => array('post' => 3))));

        $sm = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $sm->shouldReceive('get')->with('Config')->andReturn($config);

        $helper = $this->fixture->createService($sm);

        $this->assertInstanceOf('Zend\View\Helper\HelperInterface', $helper);
    }

    public function testCreationWithServiceAwareness()
    {
        $config = array('mamuz-blog' => array('pagination' => array('range' => array('post' => 3))));

        $sm = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $sm->shouldReceive('get')->with('Config')->andReturn($config);

        $helper = $this->fixture->createService($sm);

        $this->assertInstanceOf('Zend\View\Helper\HelperInterface', $helper);
    }

    public function testCreationWithServiceLocatorAwareness()
    {
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');

        $sl = \Mockery::mock('Zend\ServiceManager\AbstractPluginManager');
        $sl->shouldReceive('getServiceLocator')->andReturn($sm);

        $config = array('mamuz-blog' => array('pagination' => array('range' => array('post' => 3))));
        $sm->shouldReceive('get')->with('Config')->andReturn($config);

        $helper = $this->fixture->createService($sl);

        $this->assertInstanceOf('Zend\View\Helper\HelperInterface', $helper);
    }
}
