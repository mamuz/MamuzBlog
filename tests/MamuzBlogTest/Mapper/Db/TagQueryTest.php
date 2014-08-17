<?php

namespace MamuzBlogTest\Mapper\Db;

use Doctrine\ORM\Tools\Pagination\Paginator;
use MamuzBlog\EventManager\Event;
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

    /** @var \Zend\EventManager\EventManagerInterface | \Mockery\MockInterface */
    protected $eventManager;

    /** @var \Zend\EventManager\ResponseCollection | \Mockery\MockInterface */
    protected $reponseCollection;

    protected function setUp()
    {
        $this->entity = \Mockery::mock('MamuzBlog\Entity\Tag');
        $this->entityManager = \Mockery::mock('Doctrine\ORM\EntityManagerInterface');
        $this->range = \Mockery::mock('MamuzBlog\Options\RangeInterface');
        $this->repository = TagQuery::REPOSITORY;

        $this->fixture = new TagQuery($this->entityManager, $this->range);

        $this->eventManager = \Mockery::mock('Zend\EventManager\EventManagerInterface');
        $this->fixture->setEventManager($this->eventManager);

        $this->reponseCollection = \Mockery::mock('Zend\EventManager\ResponseCollection')->shouldIgnoreMissing();
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

    public function testFindUsedTags()
    {
        $params = array('published' => true);
        $dql = 'SELECT t FROM ' . $this->repository . ' t';

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

        $result = $this->fixture->findUsedTags();

        $this->assertInstanceOf('\IteratorAggregate', $result);
        $this->assertSame($query, $result->getQuery());
    }

    public function testFindUsedTagsWithStoppedEvent()
    {
        $params = array('published' => true);
        $dql = 'SELECT t FROM ' . $this->repository . ' t';

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

        $result = $this->fixture->findUsedTags();

        $this->assertInstanceOf('\IteratorAggregate', $result);
        $this->assertSame($query, $result->getQuery());
    }

    public function testFindUsedTagsWithCollectionEvent()
    {
        $params = array('published' => true);
        $dql = 'SELECT t FROM ' . $this->repository . ' t';

        $query = $this->createQuery($dql, $params);

        $this->prepareEventManagerForCollection($query, true, new Paginator($query));

        $result = $this->fixture->findUsedTags();

        $this->assertInstanceOf('\IteratorAggregate', $result);
        $this->assertSame($query, $result->getQuery());
    }
}
