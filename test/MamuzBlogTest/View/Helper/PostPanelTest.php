<?php

namespace MamuzBlogTest\View\Helper;

use MamuzBlog\View\Helper\PostPanel;

class PostPanelTest extends \PHPUnit_Framework_TestCase
{
    /** @var PostPanel */
    protected $fixture;

    /** @var \MamuzBlog\Entity\Post | \Mockery\MockInterface */
    protected $post;

    /** @var \Zend\View\Renderer\RendererInterface | \Mockery\MockInterface */
    protected $renderer;

    protected function setUp()
    {
        $this->post = \Mockery::mock('MamuzBlog\Entity\Post');
        $this->post->shouldReceive('getTitle')->andReturn('title');
        $this->post->shouldReceive('getContent')->andReturn('content');

        $this->renderer = \Mockery::mock('Zend\View\Renderer\RendererInterface');
        $this->renderer->shouldReceive('markdown')->with('content')->andReturn('_content_');
        $this->renderer->shouldReceive('postMeta')->with($this->post)->andReturn('_meta_');
        $this->renderer->shouldReceive('panel')->with('title', '_content_', '_meta_')->andReturn('_panel_');

        $this->fixture = new PostPanel;
        $this->fixture->setView($this->renderer);
    }

    public function testExtendingAbstractHelper()
    {
        $this->assertInstanceOf('MamuzBlog\View\Helper\AbstractHelper', $this->fixture);
        $this->assertInstanceOf('Zend\View\Helper\AbstractHelper', $this->fixture);
    }

    public function testRender()
    {
        $html = $this->fixture->render($this->post);

        $this->assertSame('_panel_', $html);

        $invoke = $this->fixture;
        $html = $invoke($this->post);
        $this->assertSame('_panel_', $html);
    }
}
