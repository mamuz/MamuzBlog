<?php

namespace MamuzBlogTest\Mapper\Db;

use Doctrine\ORM\Tools\Pagination\Paginator;
use MamuzBlog\EventManager\Event;
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

    /** @var \Zend\EventManager\EventManagerInterface | \Mockery\MockInterface */
    protected $eventManager;

    /** @var \Zend\EventManager\ResponseCollection | \Mockery\MockInterface */
    protected $reponseCollection;

    protected function setUp()
    {
        $this->entity = \Mockery::mock('MamuzBlog\Entity\Post');
        $this->entityManager = \Mockery::mock('Doctrine\ORM\EntityManagerInterface');
        $this->range = \Mockery::mock('MamuzBlog\Options\RangeInterface');
        $this->repository = PostQuery::REPOSITORY;

        $this->fixture = new PostQuery($this->entityManager, $this->range);

        $this->eventManager = \Mockery::mock('Zend\EventManager\EventManagerInterface');
        $this->fixture->setEventManager($this->eventManager);

        $this->reponseCollection = \Mockery::mock('Zend\EventManager\ResponseCollection')->shouldIgnoreMissing();
    }

    public function testImplementingPostQueryInterface()
    {
        $this->assertInstanceOf('MamuzBlog\Feature\PostQueryInterface', $this->fixture);
    }

    protected function prepareEventManagerForFind($id, $stopped = false, $entityIsNull = false)
    {
        $this->reponseCollection->shouldReceive('stopped')->once()->andReturn($stopped);

        if ($stopped) {
            $this->reponseCollection->shouldReceive('last')->andReturn($entityIsNull ? null : $this->entity);
        }

        $this->eventManager->shouldReceive('trigger')->once()->with(
            Event::PRE_FIND_PUBLISHED_POST,
            $this->fixture,
            array('id' => $id)
        )->andReturn($this->reponseCollection);
    }

    public function testFindPublishedPostById()
    {
        $id = 234;
        $this->prepareEventManagerForFind($id);

        $this->eventManager->shouldReceive('trigger')->with(
            Event::POST_FIND_PUBLISHED_POST,
            $this->fixture,
            array('id' => $id, 'post' => $this->entity)
        );

        $this->entityManager
            ->shouldReceive('find')
            ->with($this->repository, $id)
            ->andReturn($this->entity);

        $this->assertSame($this->entity, $this->fixture->findPublishedPostById($id));
    }

    public function testFindNotPublishedPostById()
    {
        $id = 234;
        $this->prepareEventManagerForFind($id, false, true);

        $this->eventManager->shouldReceive('trigger')->with(
            Event::POST_FIND_PUBLISHED_POST,
            $this->fixture,
            array('id' => $id, 'post' => null)
        );

        $this->entityManager
            ->shouldReceive('find')
            ->with($this->repository, $id)
            ->andReturn(null);

        $this->assertNull($this->fixture->findPublishedPostById($id));
    }

    public function testFindPublishedPostWithStoppedEvent()
    {
        $id = 234;
        $this->prepareEventManagerForFind($id, true, true);

        $this->eventManager->shouldReceive('trigger')->with(
            Event::POST_FIND_PUBLISHED_POST,
            $this->fixture,
            array('id' => $id, 'post' => $this->entity)
        );

        $this->entityManager
            ->shouldReceive('find')
            ->with($this->repository, $id)
            ->andReturn($this->entity);

        $this->assertSame($this->entity, $this->fixture->findPublishedPostById($id));
    }

    public function testFindPublishedPostWithEventEntity()
    {
        $id = 234;
        $this->prepareEventManagerForFind($id, true);

        $this->assertSame($this->entity, $this->fixture->findPublishedPostById($id));
    }

    public function testFluentInterfaceForCurrentPage()
    {
        $result = $this->fixture->setCurrentPage(12);
        $this->assertSame($result, $this->fixture);
    }

    protected function prepareEventManagerForCollection($query, $stopped = false, $collection = null)
    {
        $this->reponseCollection->shouldReceive('stopped')->once()->andReturn($stopped);

        if ($stopped) {
            $this->reponseCollection->shouldReceive('last')->andReturn($collection);
        }

        $this->eventManager->shouldReceive('trigger')->once()->with(
            Event::PRE_PAGINATION_CREATE,
            $this->fixture,
            array('query' => $query)
        )->andReturn($this->reponseCollection);
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

        $this->prepareEventManagerForCollection($query);
        $this->eventManager->shouldReceive('trigger')->once()->andReturnUsing(
            function ($event, $target, $result) use ($query) {
                $this->assertSame(Event::POST_PAGINATION_CREATE, $event);
                $this->assertSame($this->fixture, $target);
                $this->assertSame($query, $result['query']);
                $this->assertInstanceOf('\IteratorAggregate', $result['paginator']);
            }
        );

        $result = $this->fixture->findPublishedPosts();

        $this->assertInstanceOf('\IteratorAggregate', $result);
        $this->assertSame($query, $result->getQuery());
    }

    public function testFindPublishedPostsWithStoppedEvent()
    {
        $params = array('published' => true);
        $dql = 'SELECT p, t FROM ' . $this->repository . ' p LEFT JOIN p.tags t '
            . 'WHERE p.published = :published '
            . 'ORDER BY p.createdAt DESC';

        $query = $this->createQuery($dql, $params);

        $this->prepareEventManagerForCollection($query, true);
        $this->eventManager->shouldReceive('trigger')->once()->andReturnUsing(
            function ($event, $target, $result) use ($query) {
                $this->assertSame(Event::POST_PAGINATION_CREATE, $event);
                $this->assertSame($this->fixture, $target);
                $this->assertSame($query, $result['query']);
                $this->assertInstanceOf('\IteratorAggregate', $result['paginator']);
            }
        );

        $result = $this->fixture->findPublishedPosts();

        $this->assertInstanceOf('\IteratorAggregate', $result);
        $this->assertSame($query, $result->getQuery());
    }

    public function testFindPublishedPostsWithEventCollection()
    {
        $params = array('published' => true);
        $dql = 'SELECT p, t FROM ' . $this->repository . ' p LEFT JOIN p.tags t '
            . 'WHERE p.published = :published '
            . 'ORDER BY p.createdAt DESC';

        $query = $this->createQuery($dql, $params);

        $this->prepareEventManagerForCollection($query, true, new Paginator($query));

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

        $this->prepareEventManagerForCollection($query);
        $this->eventManager->shouldReceive('trigger')->once()->andReturnUsing(
            function ($event, $target, $result) use ($query) {
                $this->assertSame(Event::POST_PAGINATION_CREATE, $event);
                $this->assertSame($this->fixture, $target);
                $this->assertSame($query, $result['query']);
                $this->assertInstanceOf('\IteratorAggregate', $result['paginator']);
            }
        );

        $result = $this->fixture->findPublishedPostsByTag($tag);

        $this->assertInstanceOf('\IteratorAggregate', $result);
        $this->assertSame($query, $result->getQuery());
    }

    public function testFindPublishedPostsByTagWithStoppedEvent()
    {
        $tag = 'foo';
        $params = array('published' => true, 'tag' => $tag);
        $dql = 'SELECT p, t FROM ' . $this->repository . ' p LEFT JOIN p.tags t '
            . 'WHERE p.published = :published AND t.name = :tag '
            . 'ORDER BY p.createdAt DESC';

        $query = $this->createQuery($dql, $params);

        $this->prepareEventManagerForCollection($query, true);
        $this->eventManager->shouldReceive('trigger')->once()->andReturnUsing(
            function ($event, $target, $result) use ($query) {
                $this->assertSame(Event::POST_PAGINATION_CREATE, $event);
                $this->assertSame($this->fixture, $target);
                $this->assertSame($query, $result['query']);
                $this->assertInstanceOf('\IteratorAggregate', $result['paginator']);
            }
        );

        $result = $this->fixture->findPublishedPostsByTag($tag);

        $this->assertInstanceOf('\IteratorAggregate', $result);
        $this->assertSame($query, $result->getQuery());
    }

    public function testFindPublishedPostsByTagWithCollectionEvent()
    {
        $tag = 'foo';
        $params = array('published' => true, 'tag' => $tag);
        $dql = 'SELECT p, t FROM ' . $this->repository . ' p LEFT JOIN p.tags t '
            . 'WHERE p.published = :published AND t.name = :tag '
            . 'ORDER BY p.createdAt DESC';

        $query = $this->createQuery($dql, $params);

        $this->prepareEventManagerForCollection($query, true, new Paginator($query));

        $result = $this->fixture->findPublishedPostsByTag($tag);

        $this->assertInstanceOf('\IteratorAggregate', $result);
        $this->assertSame($query, $result->getQuery());
    }
}
