<?php

namespace MamuzBlogTest\View\Helper;

use MamuzBlog\View\Helper\Slug;

class SlugTest extends \PHPUnit_Framework_TestCase
{
    /** @var Slug */
    protected $fixture;

    /** @var \Cocur\Slugify\SlugifyInterface | \Mockery\MockInterface */
    protected $filter;

    /** @var string */
    protected $value = 'foo';

    /** @var string */
    protected $expected = 'foo_';

    protected function setUp()
    {
        $this->filter = \Mockery::mock('Cocur\Slugify\SlugifyInterface');
        $this->filter->shouldReceive('slugify')->with($this->value)->andReturn($this->expected);

        $this->fixture = new Slug($this->filter);
    }

    public function testExtendingAbstractHelper()
    {
        $this->assertInstanceOf('Zend\View\Helper\AbstractHelper', $this->fixture);
    }

    public function testFilter()
    {
        $this->assertSame($this->expected, $this->fixture->filter($this->value));
    }

    public function testInvokable()
    {
        $invoke = $this->fixture;
        $this->assertSame($this->expected, $invoke($this->value));
    }
}
