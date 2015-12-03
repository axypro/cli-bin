<?php
/**
 * @package axy\cli\bin
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\cli\bin\tests\tst;

use axy\cli\bin\Task;

/**
 * Test task
 */
class Cmd extends Task
{
    /**
     * {@inheritdoc}
     */
    protected function loadOpts()
    {
        if ($this->opts->getOption('a') && $this->opts->getOption('b')) {
            $this->error('only -a or -b may be specified', $this->usageStatusExit);
            return false;
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function process()
    {
        $pass = $this->silentRead('Password: ');
        $pass2 = $this->silentRead('Repeat: ');
        if ($pass !== $pass2) {
            $this->error('password != repeat', 3);
            return;
        }
        $this->out('Pass: '.$pass);
        foreach (['a', 'b', 'c'] as $opt) {
            $this->out($opt.' = '.$this->opts->getOption($opt));
        }
        do {
            $arg = $this->opts->getNextArgument();
            if ($arg) {
                $this->out($arg);
            }
        } while ($arg !== null);
    }

    /**
     * {@inheritdoc}
     */
    protected $optionsFormat = [
        'a' => false,
        'b' => false,
        'c' => true,
    ];

    /**
     * {@inheritdoc}
     */
    protected $usageStatusExit = 2;
}
