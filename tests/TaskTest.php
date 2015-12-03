<?php
/**
 * @package axy\cli\bin
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\cli\bin\tests\opts;

use axy\cli\bin\tests\tst\Cmd;
use axy\cli\bin\io\TestProcess;

/**
 * coversDefaultClass axy\cli\bin\Task
 */
class TaskTest extends \PHPUnit_Framework_TestCase
{
    public function testUsage()
    {
        $io = new TestProcess();
        $args = ['./cmd', '-ax', 'arg'];
        $cmd = new Cmd($args, $io);
        $this->assertSame($io, $cmd->run());
        $this->assertSame(2, $io->getStatus());
        $this->assertEmpty(trim(implode('', $io->getLinesOut())));
        $err = [
            'cmd: illegal option -- x',
            'Usage:',
            '    cmd -ab -c3 arg',
            '',
            '-a - this is a',
            '',
        ];
        $this->assertSame($err, $io->getLinesErr());
    }
}
