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
