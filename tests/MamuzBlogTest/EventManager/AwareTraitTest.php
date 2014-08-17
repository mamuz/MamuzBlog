<?php

namespace MamuzBlogTest\EventManager;

class AwareTraitTest extends \PHPUnit_Framework_TestCase
{
    /** @var \MamuzBlog\EventManager\AwareTrait | \PHPUnit_Framework_MockObject_MockObject */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = $this->getMockForTrait('MamuzBlog\EventManager\AwareTrait');
    }

    public function testAccessEventManager()
    {
        $eventManager = $this->fixture->getEventManager();
        $this->assertInstanceOf('Zend\EventManager\EventManagerInterface', $eventManager);

        $expectedIdentifiers = array(
            get_class($this->fixture),
            \MamuzBlog\EventManager\Event::IDENTIFIER
        );

        $identifiers = $eventManager->getIdentifiers();

        foreach ($expectedIdentifiers as $identifier) {
            $this->assertTrue(in_array($identifier, $identifiers));
        }
    }

    public function testMutateAndAccessEventManager()
    {
        $eventManager = \Mockery::mock('Zend\EventManager\EventManagerInterface');
        $this->fixture->setEventManager($eventManager);

        $this->assertSame($eventManager, $this->fixture->getEventManager());
    }
}
