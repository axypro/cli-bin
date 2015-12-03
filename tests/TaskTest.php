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

    public function testLoadOpts()
    {
        $io = new TestProcess();
        $args = ['./cmd', '-ab', 'arg'];
        $cmd = new Cmd($args, $io);
        $this->assertSame($io, $cmd->run());
        $this->assertSame(2, $io->getStatus());
        $this->assertEmpty(trim(implode('', $io->getLinesOut())));
        $err = [
            'only -a or -b may be specified',
            '',
        ];
        $this->assertSame($err, $io->getLinesErr());
    }

    public function testErrorPassword()
    {
        $io = new TestProcess(['123456', '67890']);
        $args = ['./cmd', '-ac5', 'one', 'two'];
        $cmd = new Cmd($args, $io);
        $this->assertSame($io, $cmd->run());
        $this->assertSame(3, $io->getStatus());
        $out = [
            'Password: ',
            'Repeat: ',
            '',
        ];
        $this->assertSame($out, $io->getLinesOut());
        $err = [
            'password != repeat',
            '',
        ];
        $this->assertSame($err, $io->getLinesErr());
    }

    public function testProcess()
    {
        $io = new TestProcess(['123456', '123456']);
        $args = ['./cmd', '-ac5', 'one', 'two'];
        $cmd = new Cmd($args, $io);
        $this->assertSame($io, $cmd->run());
        $this->assertSame(0, $io->getStatus());
        $this->assertEmpty(trim(implode('', $io->getLinesErr())));
        $out = [
            'Password: ',
            'Repeat: ',
            'Pass: 123456',
            'a = 1',
            'b = ',
            'c = 5',
            'one',
            'two',
            '',
        ];
        $this->assertSame($out, $io->getLinesOut());
    }
}
