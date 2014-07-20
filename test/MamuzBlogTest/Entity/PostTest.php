<?php

namespace MamuzBlogTest\Entity;

use MamuzBlog\Entity\Post;

class PostTest extends \PHPUnit_Framework_TestCase
{
    /** @var Post */
    protected $fixture;

    /** @var \DateTime */
    protected $createdAt;

    /** @var \DateTime */
    protected $modifiedAt;

    protected function setUp()
    {
        $this->createdAt = new \DateTime;
        $this->modifiedAt = new \DateTime;
        $this->fixture = new Post(1, $this->createdAt, $this->modifiedAt);
    }

    public function testCreationWithoutArguments()
    {
        $fixture = new Post;
        $this->assertNull($fixture->getId());
        $this->assertInstanceOf('\DateTime', $fixture->getCreatedAt());
        $this->assertInstanceOf('\DateTime', $fixture->getCreatedAt());
    }

    public function testClone()
    {
        $clone = clone $this->fixture;

        $this->assertNull($clone->getId());
        $this->assertNotSame($this->createdAt, $clone->getCreatedAt());
        $this->assertEquals($this->createdAt, $clone->getCreatedAt());
        $this->assertNotSame($this->modifiedAt, $clone->getModifiedAt());
        $this->assertEquals($this->modifiedAt, $clone->getModifiedAt());
    }

    public function testAccessCreatedAt()
    {
        $this->assertSame($this->createdAt, $this->fixture->getCreatedAt());
    }

    public function testAccessModifiedAt()
    {
        $this->assertSame($this->modifiedAt, $this->fixture->getModifiedAt());
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
        $this->assertSame(1, $this->fixture->getId());
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
