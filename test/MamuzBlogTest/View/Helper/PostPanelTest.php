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
        $this->renderer = \Mockery::mock('Zend\View\Renderer\RendererInterface');
        $this->renderer->shouldReceive('markdown')->with('content')->andReturn('_content_');

        $this->post = \Mockery::mock('MamuzBlog\Entity\Post');
        $this->post->shouldReceive('getId')->andReturn('id');
        $this->post->shouldReceive('getTitle')->andReturn('title');
        $this->post->shouldReceive('getContent')->andReturn('content');

        $this->fixture = new PostPanel;
        $this->fixture->setView($this->renderer);
    }

    public function testExtendingAbstractHelper()
    {
        $this->assertInstanceOf('Zend\View\Helper\AbstractHelper', $this->fixture);
    }

    public function testRender()
    {
        $this->renderer->shouldReceive('hashId')->with('id')->andReturn('id_');
        $this->renderer->shouldReceive('url')
            ->with('blogActivePost', array('title' => 'title', 'id' => 'id_'))
            ->andReturn('url');

        $html = $this->fixture->render($this->post);

        $expected = '<h3><a href="url">title</a></h3>' . PHP_EOL
            . '<div class="well">' . PHP_EOL
            . '_content_' . PHP_EOL
            . '</div>';

        $this->assertSame($expected, $html);

        $invoke = $this->fixture;
        $html = $invoke($this->post);
        $this->assertSame($expected, $html);
    }

    public function testRenderWithoutHeaderLink()
    {
        $html = $this->fixture->render($this->post, false);

        $expected = '<h3>title</h3>' . PHP_EOL
            . '<div class="well">' . PHP_EOL
            . '_content_' . PHP_EOL
            . '</div>';

        $this->assertSame($expected, $html);

        $invoke = $this->fixture;
        $html = $invoke($this->post, false);
        $this->assertSame($expected, $html);
    }
}
