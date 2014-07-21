<?php

namespace MamuzBlogTest\View\Helper;

use MamuzBlog\View\Helper\Panel;

class PanelTest extends \PHPUnit_Framework_TestCase
{
    /** @var Panel */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new Panel;
    }

    public function testExtendingAbstractHelper()
    {
        $this->assertInstanceOf('MamuzBlog\View\Helper\AbstractHelper', $this->fixture);
        $this->assertInstanceOf('Zend\View\Helper\AbstractHelper', $this->fixture);
    }

    public function testRender()
    {
        $html = $this->fixture->render('header', 'content', 'footer');

        $expected = '<article class="panel panel-default">' . PHP_EOL
            . '<header class="panel-heading"><h3 class="panel-title">header</h3></header>' . PHP_EOL
            . '<div class="panel-body"> ' . PHP_EOL
            . 'content' . PHP_EOL
            . '</div>' . PHP_EOL
            . '<div class="panel-footer">' . PHP_EOL
            . 'footer' . PHP_EOL
            . '</div>' . PHP_EOL
            . '</article>';

        $this->assertSame($expected, $html);

        $invoke = $this->fixture;
        $html = $invoke('header', 'content', 'footer');

        $this->assertSame($expected, $html);
    }
}
