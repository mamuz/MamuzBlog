<?php

namespace MamuzBlogTest\Controller;

use MamuzBlog\Crypt\HashIdAdapter;

class HashIdAdapterTest extends \PHPUnit_Framework_TestCase
{
    /** @var HashIdAdapter */
    protected $fixture;

    /** @var \Hashids\Hashids | \Mockery\MockInterface */
    protected $hashId;

    protected function setUp()
    {
        $this->hashId = \Mockery::mock('\Hashids\Hashids');

        $this->fixture = new HashIdAdapter($this->hashId);
    }

    public function testImplementingFactoryInterface()
    {
        $this->assertInstanceOf('MamuzBlog\Crypt\AdapterInterface', $this->fixture);
    }

    public function testDecrypt()
    {
        $value = 'foo';
        $this->hashId->shouldReceive('decrypt')->andReturn(array($value . '_'));

        $this->assertSame($value . '_', $this->fixture->decrypt($value));
    }

    public function testEncrypt()
    {
        $value = 'foo';
        $this->hashId->shouldReceive('encrypt')->andReturn($value . '_');

        $this->assertSame($value . '_', $this->fixture->encrypt($value));
    }
}
