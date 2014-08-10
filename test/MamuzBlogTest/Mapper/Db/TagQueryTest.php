<?php

namespace MamuzBlogTest\Mapper\Db;

use MamuzBlog\Mapper\Db\TagQuery;

class TagQueryTest extends \PHPUnit_Framework_TestCase
{
    /** @var TagQuery */
    protected $fixture;

    /** @var \Doctrine\Common\Persistence\ObjectManager | \Mockery\MockInterface */
    protected $entityManager;

    /** @var \MamuzBlog\Options\RangeInterface | \Mockery\MockInterface */
    protected $range;

    /** @var \MamuzBlog\Entity\Tag | \Mockery\MockInterface */
    protected $entity;

    /** @var string */
    protected $repository;

    protected function setUp()
    {
        $this->entity = \Mockery::mock('MamuzBlog\Entity\Tag');
        $this->entityManager = \Mockery::mock('Doctrine\ORM\EntityManagerInterface');
        $this->range = \Mockery::mock('MamuzBlog\Options\RangeInterface');
        $this->repository = TagQuery::REPOSITORY;

        $this->fixture = new TagQuery($this->entityManager, $this->range);
    }

    public function testImplementingTagQueryInterface()
    {
        $this->assertInstanceOf('MamuzBlog\Feature\TagQueryInterface', $this->fixture);
    }

    public function testFluentInterfaceForCurrentPage()
    {
        $result = $this->fixture->setCurrentPage(12);
        $this->assertSame($result, $this->fixture);
    }

    protected function createQuery($dql, array $params)
    {
        $currentPage = 12;
        $offset = 34;
        $size = 66;
        $this->fixture->setCurrentPage(12);
        $this->range->shouldReceive('getOffsetBy')->with($currentPage)->andReturn($offset);
        $this->range->shouldReceive('getSize')->andReturn($size);

        $query = \Mockery::mock('Doctrine\ORM\AbstractQuery');
        $query->shouldReceive('setFirstResult')->with($offset)->andReturn($query);
        $query->shouldReceive('setMaxResults')->with($size);
        $query->shouldReceive('setParameters')->with($params);
        $this->entityManager->shouldReceive('createQuery')->with($dql)->andReturn($query);

        return $query;
    }

    public function testFindUsedTags()
    {
        $params = array('published' => true);
        $dql = 'SELECT t FROM ' . $this->repository . ' t';

        $query = $this->createQuery($dql, $params);
        $result = $this->fixture->findUsedTags();

        $this->assertInstanceOf('\IteratorAggregate', $result);
        $this->assertSame($query, $result->getQuery());
    }
}
