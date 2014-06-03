<?php

namespace MamuzBlogTest\View\Helper;

use MamuzBlog\View\Helper\HashId;

class HashIdTest extends \PHPUnit_Framework_TestCase
{
    /** @var HashId */
    protected $fixture;

    /** @var \MamuzBlog\Crypt\AdapterInterface | \Mockery\MockInterface */
    protected $adapter;

    /** @var string */
    protected $value = 'foo';

    /** @var string */
    protected $expected = 'foo_';

    protected function setUp()
    {
        $this->adapter = \Mockery::mock('MamuzBlog\Crypt\AdapterInterface');
        $this->adapter->shouldReceive('encrypt')->with($this->value)->andReturn($this->expected);

        $this->fixture = new HashId($this->adapter);
    }

    public function testExtendingAbstractHelper()
    {
        $this->assertInstanceOf('Zend\View\Helper\AbstractHelper', $this->fixture);
    }

    public function testEncrypt()
    {
        $this->assertSame($this->expected, $this->fixture->encrypt($this->value));
    }

    public function testInvokable()
    {
        $invoke = $this->fixture;
        $this->assertSame($this->expected, $invoke($this->value));
    }
}
