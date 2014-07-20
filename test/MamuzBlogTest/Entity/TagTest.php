<?php

namespace MamuzBlogTest\Entity;

use MamuzBlog\Entity\Tag;

class TagTest extends \PHPUnit_Framework_TestCase
{
    /** @var Tag */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new Tag(1);
    }

    public function testCreationWithoutIdentity()
    {
        $fixture = new Tag;
        $this->assertNull($fixture->getId());
    }

    public function testClone()
    {
        $clone = clone $this->fixture;
        $this->assertNull($clone->getId());
    }

    public function testAccessId()
    {
        $this->assertSame(1, $this->fixture->getId());
    }

    public function testMutateAndAccessName()
    {
        $expected = 'foo';
        $this->fixture->setName($expected);
        $this->assertSame($expected, $this->fixture->getName());
    }

    public function testMutateAndAccessPosts()
    {
        $expected = new \Doctrine\Common\Collections\ArrayCollection;
        $this->fixture->setPosts($expected);
        $this->assertSame($expected, $this->fixture->getPosts());
    }
}
