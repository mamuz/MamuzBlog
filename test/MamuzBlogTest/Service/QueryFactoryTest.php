<?php

namespace MamuzBlogTest\Service;

use MamuzBlog\Service\QueryFactory;

class QueryFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var QueryFactory */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new QueryFactory;
    }

    public function testImplementingFactoryInterface()
    {
        $this->assertInstanceOf('Zend\ServiceManager\FactoryInterface', $this->fixture);
    }

    public function testCreation()
    {
        $config = array('mamuz-blog' => array('pagination' => array('range' => 3)));

        $entityManager = \Mockery::mock('Doctrine\ORM\EntityManager');
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $sm->shouldReceive('get')->with('Config')->andReturn($config);
        $sm->shouldReceive('get')->with('Doctrine\ORM\EntityManager')->andReturn($entityManager);

        $service = $this->fixture->createService($sm);

        $this->assertInstanceOf('MamuzBlog\Feature\QueryInterface', $service);
    }
}
