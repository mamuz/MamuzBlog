<?php

namespace MamuzBlogTest\Service;

use MamuzBlog\Service\Query;

class QueryTest extends \PHPUnit_Framework_TestCase
{
    /** @var Query */
    protected $fixture;

    /** @var \MamuzBlog\Feature\QueryInterface | \Mockery\MockInterface */
    protected $mapper;

    /** @var \MamuzBlog\Entity\Post | \Mockery\MockInterface */
    protected $entity;

    protected function setUp()
    {
        $this->entity = \Mockery::mock('MamuzBlog\Entity\Post');
        $this->mapper = \Mockery::mock('MamuzBlog\Feature\QueryInterface');

        $this->fixture = new Query($this->mapper);
    }

    public function testImplementingQueryInterface()
    {
        $this->assertInstanceOf('MamuzBlog\Feature\QueryInterface', $this->fixture);
    }

    public function testSetCurrentPage()
    {
        $currentPage = 3;
        $this->mapper->shouldReceive('setCurrentPage')->with($currentPage);

        $result = $this->fixture->setCurrentPage($currentPage);
        $this->assertSame($result, $this->fixture);
    }

    public function testfindActivePosts()
    {
        $this->mapper->shouldReceive('findActivePosts')->andReturn(array($this->entity));

        $this->assertSame(array($this->entity), $this->fixture->findActivePosts());
    }

    public function testfindActivePostsByTag()
    {
        $tag = 'foo';
        $this->mapper
            ->shouldReceive('findActivePostsByTag')
            ->with($tag)
            ->andReturn(array($this->entity));

        $this->assertSame(array($this->entity), $this->fixture->findActivePostsByTag($tag));
    }

    public function testfindActivePostById()
    {
        $id = 'foo';
        $this->mapper
            ->shouldReceive('findActivePostById')
            ->with($id)
            ->andReturn($this->entity);

        $this->assertSame($this->entity, $this->fixture->findActivePostById($id));
    }
}
