<?php

namespace MamuzBlogTest\Mapper\Db;

use MamuzBlog\Mapper\Db\PostQuery;

class PostQueryTest extends \PHPUnit_Framework_TestCase
{
    /** @var PostQuery */
    protected $fixture;

    /** @var \Doctrine\Common\Persistence\ObjectManager | \Mockery\MockInterface */
    protected $entityManager;

    /** @var \MamuzBlog\Options\RangeInterface | \Mockery\MockInterface */
    protected $range;

    /** @var \MamuzBlog\Entity\Post | \Mockery\MockInterface */
    protected $entity;

    /** @var string */
    protected $repository;

    protected function setUp()
    {
        $this->entity = \Mockery::mock('MamuzBlog\Entity\Post');
        $this->entityManager = \Mockery::mock('Doctrine\ORM\EntityManagerInterface');
        $this->range = \Mockery::mock('MamuzBlog\Options\RangeInterface');
        $this->repository = PostQuery::REPOSITORY;

        $this->fixture = new PostQuery($this->entityManager, $this->range);
    }

    public function testImplementingPostQueryInterface()
    {
        $this->assertInstanceOf('MamuzBlog\Feature\PostQueryInterface', $this->fixture);
    }

    public function testFindPublishedPostById()
    {
        $id = 234;
        $this->entityManager
            ->shouldReceive('find')
            ->with($this->repository, $id)
            ->andReturn($this->entity);

        $this->assertSame($this->entity, $this->fixture->findPublishedPostById($id));
    }

    public function testFindNotPublishedPostById()
    {
        $id = 234;
        $this->entityManager
            ->shouldReceive('find')
            ->with($this->repository, $id)
            ->andReturn(null);

        $this->assertNull($this->fixture->findPublishedPostById($id));
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

    public function testFindPublishedPosts()
    {
        $params = array('published' => true);
        $dql = 'SELECT p, t FROM ' . $this->repository . ' p LEFT JOIN p.tags t '
            . 'WHERE p.published = :published '
            . 'ORDER BY p.createdAt DESC';

        $query = $this->createQuery($dql, $params);
        $result = $this->fixture->findPublishedPosts();

        $this->assertInstanceOf('\IteratorAggregate', $result);
        $this->assertSame($query, $result->getQuery());
    }

    public function testFindPublishedPostsByTag()
    {
        $tag = 'foo';
        $params = array('published' => true, 'tag' => $tag);
        $dql = 'SELECT p, t FROM ' . $this->repository . ' p LEFT JOIN p.tags t '
            . 'WHERE p.published = :published AND t.name = :tag '
            . 'ORDER BY p.createdAt DESC';

        $query = $this->createQuery($dql, $params);
        $result = $this->fixture->findPublishedPostsByTag($tag);

        $this->assertInstanceOf('\IteratorAggregate', $result);
        $this->assertSame($query, $result->getQuery());
    }
}
