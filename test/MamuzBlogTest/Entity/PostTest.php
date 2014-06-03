<?php

namespace MamuzBlogTest\Entity;

use MamuzBlog\Entity\Post;

class PostTest extends \PHPUnit_Framework_TestCase
{
    /** @var Post */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new Post;
    }

    public function testClone()
    {
        $createdAt = new \DateTime;
        $modifiedAt = new \DateTime;
        $tags = $this->fixture->getTags();
        $this->fixture->setId(12);
        $this->fixture->setCreatedAt($createdAt);
        $this->fixture->setModifiedAt($modifiedAt);
        $clone = clone $this->fixture;

        $this->assertNull($clone->getId());
        $this->assertNotSame($createdAt, $clone->getCreatedAt());
        $this->assertEquals($createdAt, $clone->getCreatedAt());
        $this->assertNotSame($modifiedAt, $clone->getModifiedAt());
        $this->assertEquals($modifiedAt, $clone->getModifiedAt());
        $this->assertNotSame($tags, $clone->getTags());
        $this->assertEquals($tags, $clone->getTags());
    }

    public function testMutateAndAccessCreatedAt()
    {
        $this->assertInstanceOf('\DateTime', $this->fixture->getCreatedAt());
        $expected = new \DateTime;
        $result = $this->fixture->setCreatedAt($expected);
        $this->assertSame($expected, $this->fixture->getCreatedAt());
        $this->assertSame($result, $this->fixture);
    }

    public function testMutateAndAccessModifiedAt()
    {
        $this->assertInstanceOf('\DateTime', $this->fixture->getCreatedAt());
        $expected = new \DateTime;
        $result = $this->fixture->setModifiedAt($expected);
        $this->assertSame($expected, $this->fixture->getModifiedAt());
        $this->assertSame($result, $this->fixture);
    }

    public function testMutateAndAccessTitle()
    {
        $expected = 'foo';
        $result = $this->fixture->setTitle($expected);
        $this->assertSame($expected, $this->fixture->getTitle());
        $this->assertSame($result, $this->fixture);
    }

    public function testMutateAndAccessId()
    {
        $expected = 'foo';
        $result = $this->fixture->setId($expected);
        $this->assertSame($expected, $this->fixture->getId());
        $this->assertSame($result, $this->fixture);
    }

    public function testMutateAndAccessContent()
    {
        $expected = 'foo';
        $result = $this->fixture->setContent($expected);
        $this->assertSame($expected, $this->fixture->getContent());
        $this->assertSame($result, $this->fixture);
    }

    public function testMutateAndAccessActive()
    {
        $this->assertFalse($this->fixture->isActive());
        $result = $this->fixture->setActive(true);
        $this->assertTrue($this->fixture->isActive());
        $this->assertSame($result, $this->fixture);
    }

    public function testMutateAndAccessTags()
    {
        $expected = new \Doctrine\Common\Collections\ArrayCollection;
        $result = $this->fixture->setTags($expected);
        $this->assertSame($expected, $this->fixture->getTags());
        $this->assertSame($result, $this->fixture);
    }
}
