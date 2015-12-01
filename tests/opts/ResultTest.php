<?php
/**
 * @package axy\cli\bin
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\cli\bin\tests\opts;

use axy\cli\bin\opts\Result;

/**
 * coversDefaultClass axy\cli\bin\opts\Result
 */
class ResultTest extends \PHPUnit_Framework_TestCase
{
    /**
     * covers ::getOption
     */
    public function testGetOptions()
    {
        $result = new Result();
        $result->options = ['b' => true, 'C' => 5];
        $this->assertSame(true, $result->getOption('b'));
        $this->assertSame(5, $result->getOption('C'));
        $this->assertSame(5, $result->getOption('C', 6));
        $this->assertSame(6, $result->getOption('c', 6));
        $this->assertSame(null, $result->getOption('c'));
    }

    /**
     * covers ::getNextArgument
     */
    public function testGetNextArgument()
    {
        $result = new Result();
        $result->args = ['one', 'two'];
        $this->assertSame('one', $result->getNextArgument());
        $this->assertSame('two', $result->getNextArgument());
        $this->assertNull($result->getNextArgument());
        $this->assertNull($result->getNextArgument());
    }
}
