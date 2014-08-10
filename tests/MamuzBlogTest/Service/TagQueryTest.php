<?php

namespace MamuzBlogTest\Service;

use MamuzBlog\Service\TagQuery;

class TagQueryTest extends \PHPUnit_Framework_TestCase
{
    /** @var TagQuery */
    protected $fixture;

    /** @var \MamuzBlog\Feature\TagQueryInterface | \Mockery\MockInterface */
    protected $mapper;

    /** @var \MamuzBlog\Entity\Tag | \Mockery\MockInterface */
    protected $entity;

    protected function setUp()
    {
        $this->entity = \Mockery::mock('MamuzBlog\Entity\Tag');
        $this->mapper = \Mockery::mock('MamuzBlog\Feature\TagQueryInterface');

        $this->fixture = new TagQuery($this->mapper);
    }

    public function testImplementingTagQueryInterface()
    {
        $this->assertInstanceOf('MamuzBlog\Feature\TagQueryInterface', $this->fixture);
    }

    public function testSetCurrentPage()
    {
        $currentPage = 3;
        $this->mapper->shouldReceive('setCurrentPage')->with($currentPage);

        $result = $this->fixture->setCurrentPage($currentPage);
        $this->assertSame($result, $this->fixture);
    }

    public function testFindUsedTags()
    {
        $tags = array($this->entity, $this->entity);
        $this->mapper->shouldReceive('findUsedTags')->andReturn($tags);

        $this->assertSame($tags, $this->fixture->findUsedTags());
    }
}
