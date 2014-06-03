<?php

namespace MamuzBlogTest\Service;

use MamuzBlog\DomainManager\Factory;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var Factory */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new Factory;
    }

    public function testImplementingFactoryInterface()
    {
        $this->assertInstanceOf('Zend\ServiceManager\FactoryInterface', $this->fixture);
    }

    public function testCreation()
    {
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceManager');
        $service = $this->fixture->createService($sm);

        $this->assertInstanceOf('Zend\ServiceManager\ServiceLocatorInterface', $service);
    }
}
