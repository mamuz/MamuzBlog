<?php

namespace MamuzBlogTest\View\Helper;

use MamuzBlog\View\Helper\Tag;

class TagTest extends \PHPUnit_Framework_TestCase
{
    /** @var Tag */
    protected $fixture;

    /** @var \Zend\View\Renderer\RendererInterface | \Mockery\MockInterface */
    protected $renderer;

    /** @var array */
    protected $posts = array(2, 4);

    /** @var \MamuzBlog\Entity\Tag | \Mockery\MockInterface */
    protected $entity;

    protected function setUp()
    {
        $this->entity = \Mockery::mock('MamuzBlog\Entity\Tag');
        $this->entity->shouldReceive('getName')->andReturn('tagname');

        $this->renderer = \Mockery::mock('Zend\View\Renderer\RendererInterface');
        $this->renderer->shouldReceive('translate')->with('tagname')->andReturn('_tagname_');
        $this->renderer->shouldReceive('badge')->with(count($this->posts))->andReturn('badge');
        $this->renderer->shouldReceive('tagAnchor')->with('tagname', '_tagname_badge')->andReturn('anchor');

        $this->fixture = new Tag;
        $this->fixture->setView($this->renderer);
    }

    public function testExtendingAbstractHelper()
    {
        $this->assertInstanceOf('MamuzBlog\View\Helper\AbstractHelper', $this->fixture);
        $this->assertInstanceOf('Zend\View\Helper\AbstractHelper', $this->fixture);
    }

    public function testRender()
    {
        $this->entity->shouldReceive('getPosts')->andReturn($this->posts);

        $html = $this->fixture->render($this->entity);
        $this->assertSame('anchor', $html);

        $invoke = $this->fixture;
        $html = $invoke($this->entity);
        $this->assertSame('anchor', $html);
    }

    public function testRenderWithEmptyPosts()
    {
        $this->entity->shouldReceive('getPosts')->andReturn(array());

        $html = $this->fixture->render($this->entity);
        $this->assertSame('', $html);

        $invoke = $this->fixture;
        $html = $invoke($this->entity);
        $this->assertSame('', $html);
    }
}
