<?php
/**
 * @package axy\cli\bin
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\cli\bin\tests\io;

use axy\cli\bin\io\TestProcess;

/**
 * coversDefaultClass axy\cli\bin\io\TestProcess
 */
class TestProcessTest extends \PHPUnit_Framework_TestCase
{
    /**
     * covers ::setStatus
     * covers ::getStatus
     */
    public function testStatus()
    {
        $process = new TestProcess();
        $this->assertSame(0, $process->getStatus());
        $process->setStatus(5);
        $this->assertSame(5, $process->getStatus());
    }

    /**
     * covers ::write
     * covers ::error
     * covers ::readLine
     */
    public function testOut()
    {
        $process = new TestProcess(['one', 'two']);
        $process->write('Test');
        $process->write($process->readLine());
        $process->error('error!', 5);
        $process->write('Password: ', false);
        $this->assertSame('two', $process->silentReadLine());
        $process->write('End');
        $this->assertNull($process->readLine());
        $expectedOut = [
            'Test',
            'one',
            'Password: End',
            '',
        ];
        $expectedErr = [
            'error!',
            '',
        ];
        $this->assertSame($expectedOut, $process->getLinesOut());
        $this->assertSame($expectedErr, $process->getLinesErr());
    }

    /**
     * covers ::readLine
     * covers ::readAll
     */
    public function testReadAll()
    {
        $process = new TestProcess(['one', 'two', 'three', 'four']);
        $this->assertSame('one', $process->readLine());
        $expected = 'two'.PHP_EOL.'three'.PHP_EOL.'four'.PHP_EOL;
        $this->assertSame($expected, $process->readAll());
        $this->assertNull($process->readAll());
        $this->assertNull($process->readLine());
    }
}
