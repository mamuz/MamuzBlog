<?php

namespace MamuzBlogTest\View\Helper;

use MamuzBlog\View\Helper\PostPanelShort;

class PostPanelShortTest extends \PHPUnit_Framework_TestCase
{
    /** @var PostPanelShort */
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
        $this->post->shouldReceive('getDescription')->andReturn('desc');
        $this->post->shouldReceive('getId')->andReturn(12);

        $this->renderer = \Mockery::mock('Zend\View\Renderer\RendererInterface');
        $this->renderer->shouldReceive('markdown')->with('desc')->andReturn('_content_');
        $this->renderer->shouldReceive('hashId')->with(12)->andReturn('hashId');
        $this->renderer->shouldReceive('url')->with(
            'blogActivePost',
            array('title' => 'title', 'id' => 'hashId')
        )->andReturn('url');
        $this->renderer->shouldReceive('anchor')->with('url', 'Go to post', 'title')->andReturn('anchor1');
        $this->renderer->shouldReceive('anchor')->with('url', 'Go to post', 'Read more')->andReturn('anchor2');
        $this->renderer->shouldReceive('postMeta')->with($this->post)->andReturn('_meta_');
        $this->renderer->shouldReceive('panel')->with('anchor1', '_content_anchor2', '_meta_')->andReturn('_panel_');

        $this->fixture = new PostPanelShort;
        $this->fixture->setView($this->renderer);
    }

    public function testExtendingAbstractHelper()
    {
        $this->assertInstanceOf('MamuzBlog\View\Helper\PostPanel', $this->fixture);
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
