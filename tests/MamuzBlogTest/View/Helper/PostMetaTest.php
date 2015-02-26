<?php

namespace MamuzBlogTest\View\Helper;

use MamuzBlog\View\Helper\PostMeta;

class PostMetaTest extends \PHPUnit_Framework_TestCase
{
    /** @var PostMeta */
    protected $fixture;

    /** @var \MamuzBlog\Entity\Post | \Mockery\MockInterface */
    protected $post;

    /** @var \Zend\View\Renderer\RendererInterface | \Mockery\MockInterface */
    protected $renderer;

    protected function setUp()
    {
        $tag1 = \Mockery::mock('MamuzBlog\Entity\Tag');
        $tag1->shouldReceive('getName')->andReturn('tag1');
        $tag2 = \Mockery::mock('MamuzBlog\Entity\Tag');
        $tag2->shouldReceive('getName')->andReturn('tag2');

        $tags = new \ArrayIterator(array($tag1, $tag2));
        $modifiedAt = new \DateTime('2012-12-12');

        $this->post = \Mockery::mock('MamuzBlog\Entity\Post');
        $this->post->shouldReceive('getTags')->andReturn($tags);
        $this->post->shouldReceive('getModifiedAt')->andReturn($modifiedAt);

        $this->renderer = \Mockery::mock('Zend\View\Renderer\RendererInterface');
        $this->renderer->shouldReceive('glyphicon')->with('calendar')->andReturn('icon');
        $this->renderer
            ->shouldReceive('dateFormat')
            ->with($modifiedAt, \IntlDateFormatter::LONG, \IntlDateFormatter::NONE)
            ->andReturn('datestring');
        $this->renderer->shouldReceive('translate')->with('tag1')->andReturn('_tag1');
        $this->renderer->shouldReceive('translate')->with('tag2')->andReturn('_tag2');
        $this->renderer->shouldReceive('badge')->with('_tag1')->andReturn('badge1');
        $this->renderer->shouldReceive('badge')->with('_tag2')->andReturn('badge2');
        $this->renderer
            ->shouldReceive('tagAnchor')
            ->with('tag1', 'badge1')->andReturn('anchor1');
        $this->renderer
            ->shouldReceive('tagAnchor')
            ->with('tag2', 'badge2')->andReturn('anchor2');

        $this->fixture = new PostMeta;
        $this->fixture->setView($this->renderer);
    }

    public function testExtendingAbstractHelper()
    {
        $this->assertInstanceOf('MamuzBlog\View\Helper\AbstractHelper', $this->fixture);
        $this->assertInstanceOf('Zend\View\Helper\AbstractHelper', $this->fixture);
    }

    public function testRender()
    {
        $expected = '<span>icon<time datetime="2012-12-12">datestring</time></span>' . PHP_EOL
            . '<span class="pull-right">anchor1' . PHP_EOL . 'anchor2' . PHP_EOL . '</span>';

        $this->assertSame($expected, $this->fixture->render($this->post));

        $invoke = $this->fixture;
        $html = $invoke($this->post);

        $this->assertSame($expected, $html);
    }
}
