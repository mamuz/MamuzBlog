<?php

namespace MamuzBlogTest\Service;

use MamuzBlog\Service\PostQuery;

class PostQueryTest extends \PHPUnit_Framework_TestCase
{
    /** @var PostQuery */
    protected $fixture;

    /** @var \MamuzBlog\Feature\PostQueryInterface | \Mockery\MockInterface */
    protected $mapper;

    /** @var \MamuzBlog\Entity\Post | \Mockery\MockInterface */
    protected $entity;

    protected function setUp()
    {
        $this->entity = \Mockery::mock('MamuzBlog\Entity\Post');
        $this->mapper = \Mockery::mock('MamuzBlog\Feature\PostQueryInterface');

        $this->fixture = new PostQuery($this->mapper);
    }

    public function testImplementingPostQueryInterface()
    {
        $this->assertInstanceOf('MamuzBlog\Feature\PostQueryInterface', $this->fixture);
    }

    public function testSetCurrentPage()
    {
        $currentPage = 3;
        $this->mapper->shouldReceive('setCurrentPage')->with($currentPage);

        $result = $this->fixture->setCurrentPage($currentPage);
        $this->assertSame($result, $this->fixture);
    }

    public function testFindActivePosts()
    {
        $this->mapper->shouldReceive('findActivePosts')->andReturn(array($this->entity));

        $this->assertSame(array($this->entity), $this->fixture->findActivePosts());
    }

    public function testFindActivePostsByTag()
    {
        $tag = 'foo';
        $this->mapper
            ->shouldReceive('findActivePostsByTag')
            ->with($tag)
            ->andReturn(array($this->entity));

        $this->assertSame(array($this->entity), $this->fixture->findActivePostsByTag($tag));
    }

    public function testFindActivePostById()
    {
        $id = 'foo';
        $this->mapper
            ->shouldReceive('findActivePostById')
            ->with($id)
            ->andReturn($this->entity);

        $this->assertSame($this->entity, $this->fixture->findActivePostById($id));
    }
}
