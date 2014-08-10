<?php

namespace MamuzBlogTest\Controller;

use MamuzBlog\Crypt\HashIdAdapterFactory;

class HashIdAdapterFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Zend\ServiceManager\ServiceLocatorInterface | \Mockery\MockInterface */
    protected $serviceLocator;

    /** @var HashIdAdapterFactory */
    protected $fixture;

    protected function setUp()
    {
        $this->serviceLocator = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $this->serviceLocator->shouldReceive('getServiceLocator')->andReturn($this->serviceLocator);

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
        $this->serviceLocator->shouldReceive('get')->with('Config')->andReturn($config);

        $cryptEngine = $this->fixture->createService($this->serviceLocator);

        $this->assertInstanceOf('MamuzBlog\Crypt\AdapterInterface', $cryptEngine);
    }

    public function testCreationWithInvalidConfigMissingSault()
    {
        $this->setExpectedException('Zend\ServiceManager\Exception\ServiceNotCreatedException');

        $config = array(
            'crypt' => array(
                'hashid' => array(
                    'minLength' => 9,
                    'chars'     => '1234567890qwertzu',
                )
            )
        );
        $this->serviceLocator->shouldReceive('get')->with('Config')->andReturn($config);

        $this->fixture->createService($this->serviceLocator);
    }

    public function testCreationWithInvalidConfigMissingMinLength()
    {
        $this->setExpectedException('Zend\ServiceManager\Exception\ServiceNotCreatedException');

        $config = array(
            'crypt' => array(
                'hashid' => array(
                    'sault' => 'dfgdfgdfgdfgdfg',
                    'chars' => '1234567890qwertzu',
                )
            )
        );
        $this->serviceLocator->shouldReceive('get')->with('Config')->andReturn($config);

        $this->fixture->createService($this->serviceLocator);
    }

    public function testCreationWithInvalidConfigMissingChars()
    {
        $this->setExpectedException('Zend\ServiceManager\Exception\ServiceNotCreatedException');

        $config = array(
            'crypt' => array(
                'hashid' => array(
                    'sault'     => 'dfgdfgdfgdfgdfg',
                    'minLength' => 9,
                )
            )
        );
        $this->serviceLocator->shouldReceive('get')->with('Config')->andReturn($config);

        $this->fixture->createService($this->serviceLocator);
    }
}
