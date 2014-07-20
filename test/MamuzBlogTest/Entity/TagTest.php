<?php

namespace MamuzBlogTest\Entity;

use MamuzBlog\Entity\Tag;

class TagTest extends \PHPUnit_Framework_TestCase
{
    /** @var Tag */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new Tag;
    }

    public function testClone()
    {
        $posts = $this->fixture->getPosts();
        $clone = clone $this->fixture;

        $this->assertNull($clone->getId());
        $this->assertNotSame($posts, $clone->getPosts());
        $this->assertEquals($posts, $clone->getPosts());
    }

    public function testAccessId()
    {
        $this->assertNull($this->fixture->getId());
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
