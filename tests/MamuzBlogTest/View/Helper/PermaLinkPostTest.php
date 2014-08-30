<?php

namespace MamuzBlogTest\View\Helper;

use MamuzBlog\View\Helper\PermaLinkPost;

class PermaLinkPostTest extends \PHPUnit_Framework_TestCase
{
    /** @var PermaLinkPost */
    protected $fixture;

    /** @var \MamuzBlog\Entity\Post | \Mockery\MockInterface */
    protected $post;

    /** @var \Zend\View\Renderer\RendererInterface | \Mockery\MockInterface */
    protected $renderer;

    protected function setUp()
    {
        $this->post = \Mockery::mock('MamuzBlog\Entity\Post');
        $this->post->shouldReceive('getTitle')->andReturn('title');
        $this->post->shouldReceive('getId')->andReturn(12);

        $this->renderer = \Mockery::mock('Zend\View\Renderer\RendererInterface');
        $this->renderer->shouldReceive('hashId')->with(12)->andReturn('_hashId_');
        $this->renderer->shouldReceive('slugify')->with('title')->andReturn('_title_');
        $this->renderer->shouldReceive('serverUrl')->andReturn('server_');
        $this->renderer->shouldReceive('url')->with(
            'blogPublishedPost',
            array('title' => '_title_', 'id' => '_hashId_')
        )->andReturn('url');

        $this->fixture = new PermaLinkPost;
        $this->fixture->setView($this->renderer);
    }

    public function testExtendingAbstractHelper()
    {
        $this->assertInstanceOf('MamuzBlog\View\Helper\AbstractHelper', $this->fixture);
    }

    public function testRender()
    {
        $permaLink = $this->fixture->render($this->post);

        $this->assertSame('server_url', $permaLink);

        $invoke = $this->fixture;
        $permaLink = $invoke($this->post);
        $this->assertSame('server_url', $permaLink);
    }
}
