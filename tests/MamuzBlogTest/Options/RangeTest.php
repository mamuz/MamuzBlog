<?php

namespace MamuzBlogTest\Options;

use MamuzBlog\Options\Range;

class RangeTest extends \PHPUnit_Framework_TestCase
{
    /** @var Range */
    protected $fixture;

    /** @var int */
    protected $size = 10;

    protected function setUp()
    {
        $this->fixture = new Range($this->size);
    }

    public function testImplementingRangeInterface()
    {
        $this->assertInstanceOf('MamuzBlog\Options\RangeInterface', $this->fixture);
    }

    public function testAccessSize()
    {
        $this->assertSame($this->size, $this->fixture->getSize());
    }

    public function testAccessOffsetBy()
    {
        $point = 20;
        $expected = $this->size * ($point - 1);
        $this->assertSame($expected, $this->fixture->getOffsetBy($point));
    }
}
