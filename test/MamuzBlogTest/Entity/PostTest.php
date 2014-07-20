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
        $clone = clone $this->fixture;

        $this->assertNull($clone->getId());
        $this->assertNotSame($createdAt, $clone->getCreatedAt());
        $this->assertEquals($createdAt, $clone->getCreatedAt());
        $this->assertNotSame($modifiedAt, $clone->getModifiedAt());
        $this->assertEquals($modifiedAt, $clone->getModifiedAt());
        $this->assertNotSame($tags, $clone->getTags());
        $this->assertEquals($tags, $clone->getTags());
    }

    public function testAccessCreatedAt()
    {
        $this->assertInstanceOf('\DateTime', $this->fixture->getCreatedAt());
    }

    public function testAccessModifiedAt()
    {
        $this->assertInstanceOf('\DateTime', $this->fixture->getCreatedAt());
    }

    public function testMutateAndAccessTitle()
    {
        $expected = 'foo';
        $result = $this->fixture->setTitle($expected);
        $this->assertSame($expected, $this->fixture->getTitle());
        $this->assertSame($result, $this->fixture);
    }

    public function testAccessId()
    {
        $this->assertNull($this->fixture->getId());
    }

    public function testMutateAndAccessContent()
    {
        $expected = 'foo';
        $result = $this->fixture->setContent($expected);
        $this->assertSame($expected, $this->fixture->getContent());
        $this->assertSame($result, $this->fixture);
    }

    public function testMutateAndAccessDescription()
    {
        $expected = 'foo';
        $result = $this->fixture->setDescription($expected);
        $this->assertSame($expected, $this->fixture->getDescription());
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
