<?php
/**
 * @package axy\cli\bin
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\cli\bin\tests\io;

use axy\cli\bin\io\RealProcess;

/**
 * coversDefaultClass axy\cli\bin\io\RealProcess
 */
class RealProcessTest extends \PHPUnit_Framework_TestCase
{
    /**
     * covers ::setStatus
     * covers ::getStatus
     */
    public function testStatus()
    {
        $process = new RealProcess();
        $this->assertSame(0, $process->getStatus());
        $process->setStatus(7);
        $this->assertSame(7, $process->getStatus());
    }
}
