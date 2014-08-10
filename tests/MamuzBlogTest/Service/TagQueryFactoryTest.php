<?php

namespace MamuzBlogTest\Service;

use MamuzBlog\Service\TagQueryFactory;

class TagQueryFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var TagQueryFactory */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new TagQueryFactory;
    }

    public function testImplementingFactoryInterface()
    {
        $this->assertInstanceOf('Zend\ServiceManager\FactoryInterface', $this->fixture);
    }

    public function testCreation()
    {
        $config = array('mamuz-blog' => array('pagination' => array('range' => array('tag' => 3))));

        $entityManager = \Mockery::mock('Doctrine\ORM\EntityManager');
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $sm->shouldReceive('get')->with('Config')->andReturn($config);
        $sm->shouldReceive('get')->with('Doctrine\ORM\EntityManager')->andReturn($entityManager);

        $service = $this->fixture->createService($sm);

        $this->assertInstanceOf('MamuzBlog\Feature\TagQueryInterface', $service);
    }
}
