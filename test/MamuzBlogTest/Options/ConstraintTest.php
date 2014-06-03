<?php

namespace MamuzBlogTest\Options;

use MamuzBlog\Options\Constraint;

class ConstraintTest extends \PHPUnit_Framework_TestCase
{
    /** @var Constraint */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new Constraint;
    }

    public function testImplementingConstraintInterface()
    {
        $this->assertInstanceOf('MamuzBlog\Options\ConstraintInterface', $this->fixture);
    }

    public function testFluentInterfaceForAdd()
    {
        $this->assertSame($this->fixture, $this->fixture->add('foo', 'bar', 'baz'));
    }

    public function testIsEmpty()
    {
        $this->assertTrue($this->fixture->isEmpty());
        $this->fixture->add('foo', 'bar', 'baz');
        $this->assertFalse($this->fixture->isEmpty());
    }

    public function testStringRepresentation()
    {
        $this->fixture->add('foo', 'bar', 'baz');
        $this->fixture->add('foo2', 'bar2', 'baz2');

        $this->assertSame('bar bar2', $this->fixture->toString());
    }

    public function testArrayRepresentation()
    {
        $this->fixture->add('foo', 'bar', 'baz');
        $this->fixture->add('foo2', 'bar2', 'baz2');

        $this->assertSame(array('foo' => 'baz', 'foo2' => 'baz2'), $this->fixture->toArray());
    }
}
