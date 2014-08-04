<?php

namespace MamuzBlogTest\View\Helper;

use MamuzBlog\View\Helper\TagList;

class TagListTest extends \PHPUnit_Framework_TestCase
{
    /** @var TagList */
    protected $fixture;

    /** @var \Zend\View\Renderer\RendererInterface | \Mockery\MockInterface */
    protected $renderer;

    protected function setUp()
    {
        $usedTags = array(1, 2);
        $mvcEvent = \Mockery::mock('Zend\Mvc\MvcEvent');
        $mvcEvent->shouldReceive('getRouteMatch')->andReturn($mvcEvent);
        $mvcEvent->shouldReceive('getParam')->with('tag', false)->andReturn('tagParam');
        $tagQueryService = \Mockery::mock('MamuzBlog\Feature\TagQueryInterface');
        $tagQueryService->shouldReceive('findUsedTags')->andReturn($usedTags);
        $this->renderer = \Mockery::mock('Zend\View\Renderer\RendererInterface');
        $this->renderer
            ->shouldReceive('partial')
            ->with(
                'mamuz-blog/tag-query/items',
                array(
                    'collection' => $usedTags,
                    'currentTag' => 'tagParam',
                )
            )
            ->andReturn('rendered');

        $this->fixture = new TagList($mvcEvent, $tagQueryService);
        $this->fixture->setView($this->renderer);
    }

    public function testExtendingAbstractHelper()
    {
        $this->assertInstanceOf('MamuzBlog\View\Helper\AbstractHelper', $this->fixture);
        $this->assertInstanceOf('Zend\View\Helper\AbstractHelper', $this->fixture);
    }

    public function testRender()
    {
        $this->assertSame('rendered', $this->fixture->render());

        $invoke = $this->fixture;
        $this->assertSame('rendered', $invoke());
    }
}
