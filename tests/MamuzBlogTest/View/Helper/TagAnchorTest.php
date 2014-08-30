<?php

namespace MamuzBlogTest\View\Helper;

use MamuzBlog\View\Helper\TagAnchor;

class TagAnchorTest extends \PHPUnit_Framework_TestCase
{
    /** @var TagAnchor */
    protected $fixture;

    /** @var \Zend\View\Renderer\RendererInterface | \Mockery\MockInterface */
    protected $renderer;

    protected function setUp()
    {
        $this->renderer = \Mockery::mock('Zend\View\Renderer\RendererInterface');
        $this->renderer->shouldReceive('permaLinkTag')->with('tagname')->andReturn('url');
        $this->renderer
            ->shouldReceive('anchorBookmark')
            ->with('url', 'Go to specific list', 'content')->andReturn('anchor');

        $this->fixture = new TagAnchor;
        $this->fixture->setView($this->renderer);
    }

    public function testExtendingAbstractHelper()
    {
        $this->assertInstanceOf('MamuzBlog\View\Helper\AbstractHelper', $this->fixture);
        $this->assertInstanceOf('Zend\View\Helper\AbstractHelper', $this->fixture);
    }

    public function testRender()
    {
        $html = $this->fixture->render('tagname', 'content');
        $this->assertSame('anchor', $html);

        $invoke = $this->fixture;
        $html = $invoke('tagname', 'content');
        $this->assertSame('anchor', $html);
    }
}
