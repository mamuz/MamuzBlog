<?php

namespace MamuzBlogTest\View\Helper;

use MamuzBlog\View\Helper\Pager;

class PagerTest extends \PHPUnit_Framework_TestCase
{
    /** @var Pager */
    protected $fixture;

    /** @var \MamuzBlog\Options\RangeInterface | \Mockery\MockInterface */
    protected $range;

    /** @var \Zend\View\Renderer\RendererInterface | \Mockery\MockInterface */
    protected $renderer;

    /** @var int */
    protected $size = 2;

    /** @var \ArrayObject */
    protected $collection = 'foo_';

    protected function setUp()
    {
        $this->collection = new \ArrayObject;
        $this->renderer = \Mockery::mock('Zend\View\Renderer\RendererInterface');
        $this->range = \Mockery::mock('MamuzBlog\Options\RangeInterface');
        $this->range->shouldReceive('getSize')->andReturn($this->size);

        $this->fixture = new Pager($this->range, 'route', 'page');
        $this->fixture->setView($this->renderer);
    }

    public function testExtendingAbstractHelper()
    {
        $this->assertInstanceOf('MamuzBlog\View\Helper\AbstractHelper', $this->fixture);
        $this->assertInstanceOf('Zend\View\Helper\AbstractHelper', $this->fixture);
    }

    public function testRender()
    {
        for ($i = 1; $i < 7; $i++) {
            $this->collection->append($i);
        }
        $this->renderer->shouldReceive('url')->with('route', array('page' => 1))->andReturn('prev');
        $this->renderer->shouldReceive('url')->with('route', array('page' => 3))->andReturn('next');

        $html = $this->fixture->render($this->collection, array('page' => 2));

        $expected = '<a class="prev" href="prev">&laquo;</a>' . PHP_EOL
            . '<a class="next" href="next">&raquo;</a>' . PHP_EOL;

        $this->assertSame($expected, $html);

        $invoke = $this->fixture;
        $html = $invoke($this->collection, array('page' => 2));
        $this->assertSame($expected, $html);
    }

    public function testRenderPagerStart()
    {
        for ($i = 1; $i < 7; $i++) {
            $this->collection->append($i);
        }
        $this->renderer->shouldReceive('url')->with('route', array('page' => 2))->andReturn('next');

        $html = $this->fixture->render($this->collection, array('page' => 1));

        $expected = '<a class="next" href="next">&raquo;</a>' . PHP_EOL;

        $this->assertSame($expected, $html);

        $invoke = $this->fixture;
        $html = $invoke($this->collection, array('page' => 1));
        $this->assertSame($expected, $html);
    }

    public function testRenderPagerEnd()
    {
        for ($i = 1; $i < 7; $i++) {
            $this->collection->append($i);
        }
        $this->renderer->shouldReceive('url')->with('route', array('page' => 2))->andReturn('prev');

        $html = $this->fixture->render($this->collection, array('page' => 3));

        $expected = '<a class="prev" href="prev">&laquo;</a>' . PHP_EOL;

        $this->assertSame($expected, $html);

        $invoke = $this->fixture;
        $html = $invoke($this->collection, array('page' => 3));
        $this->assertSame($expected, $html);
    }

    public function testRenderCollectionEmpty()
    {
        $html = $this->fixture->render($this->collection, array('page' => 2));

        $expected = '';

        $this->assertSame($expected, $html);

        $invoke = $this->fixture;
        $html = $invoke($this->collection, array('page' => 2));
        $this->assertSame($expected, $html);
    }
}
