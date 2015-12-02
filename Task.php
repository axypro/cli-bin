<?php
/**
 * @package axy\cli\bin
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\cli\bin;

use axy\cli\bin\io\IProcess;
use axy\cli\bin\io\RealProcess;
use axy\cli\bin\opts\Parser;
use axy\evil\Superglobals;

/**
 * Interface of the bin task
 */
abstract class Task
{
    /**
     * The constructor
     *
     * @param string[] $argv [optional]
     * @param IProcess $io [optional]
     */
    public function __construct(array $argv = null, IProcess $io = null)
    {
        if ($argv === null) {
            $argv = Superglobals::getSERVER()['argv'];
        }
        $this->opts = Parser::parse($argv, $this->optionsFormat);
        $this->io = $io ?: new RealProcess();
    }

    /**
     * Executes the task
     *
     * @return \axy\cli\bin\io\IProcess
     */
    public function run()
    {
        return $this->io;
    }

    /**
     * @var \axy\cli\bin\opts\Result
     */
    protected $opts;

    /**
     * @var \axy\cli\bin\io\IProcess
     */
    protected $io;

    /**
     * For override
     *
     * @var array
     */
    protected $optionsFormat = [];
}
