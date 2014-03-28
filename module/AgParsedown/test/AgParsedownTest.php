<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace AgParsedownTest;

use PHPUnit_Framework_TestCase as TestCase;
use AgParsedown\AgParsedown;
use Parsedown;

class AgParsedownTest extends TestCase
{
    public function setUp()
    {
        $this->parsedown = new Parsedown();
        $this->helper    = new AgParsedown($this->parsedown);
    }

    public function testCanRetrieveComposedParsedownInstance()
    {
        $this->assertSame($this->parsedown, $this->helper->getParsedown());
    }

    public function testInvokeReturnsHTMLParsedFromMarkdown()
    {
        $string = 'Hello _Parsedown_!';
        $this->assertEquals($this->parsedown->parse($string), $this->helper->__invoke($string));
    }
}
