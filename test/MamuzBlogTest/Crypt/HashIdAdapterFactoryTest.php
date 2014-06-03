<?php

namespace MamuzBlogTest\Controller;

use MamuzBlog\Crypt\HashIdAdapterFactory;

class HashIdAdapterFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var HashIdAdapterFactory */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new HashIdAdapterFactory;
    }

    public function testImplementingFactoryInterface()
    {
        $this->assertInstanceOf('Zend\ServiceManager\FactoryInterface', $this->fixture);
    }

    public function testCreation()
    {
        $config = array(
            'crypt' => array(
                'hashid' => array(
                    'sault'     => 'dfgdfgdfgdfgdfg',
                    'minLength' => 9,
                    'chars'     => '1234567890qwertzu',
                )
            )
        );

        $sm = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $sm->shouldReceive('getServiceLocator')->andReturn($sm);
        $sm->shouldReceive('get')->with('Config')->andReturn($config);

        $cryptEngine = $this->fixture->createService($sm);

        $this->assertInstanceOf('MamuzBlog\Crypt\AdapterInterface', $cryptEngine);
    }
}
