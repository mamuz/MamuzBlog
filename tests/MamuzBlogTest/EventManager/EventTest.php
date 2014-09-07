<?php

namespace MamuzBlogTest\EventManager;

use MamuzBlog\EventManager\Event;

class EventTest extends \PHPUnit_Framework_TestCase
{
    public function testEventIdentifier()
    {
        $this->assertSame('mamuz-blog', Event::IDENTIFIER);
    }

    public function testEventNames()
    {
        $this->assertSame('createPaginator.pre', Event::PRE_PAGINATION_CREATE);
        $this->assertSame('createPaginator.post', Event::POST_PAGINATION_CREATE);
        $this->assertSame('findPublishedPost.pre', Event::PRE_FIND_PUBLISHED_POST);
        $this->assertSame('findPublishedPost.post', Event::POST_FIND_PUBLISHED_POST);
    }
}
