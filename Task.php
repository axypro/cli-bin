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
        if ($this->opts->error !== null) {
            if ($this->opts->error !== '') {
                $top = '{cmd}: ' . $this->opts->error;
            } else {
                $top = '';
            }
            $this->usage($top);
            return $this->io;
        }
        if (!$this->loadOpts()) {
            return $this->io;
        }
        $this->process();
        return $this->io;
    }

    /**
     * @param string $top [optional]
     * @param int $status [optional]
     */
    protected function usage($top = null, $status = null)
    {
        $rc = new \ReflectionClass($this);
        $fn = dirname($rc->getFileName()).'/'.$this->fileUsage;
        if (is_file($fn)) {
            $content = rtrim(file_get_contents($fn)).PHP_EOL;
        } else {
            $content = '';
        }
        if ($top) {
            $content = $top.PHP_EOL.$content;
        }
        $content = str_replace('{cmd}', basename($this->opts->command), $content);
        if ($status === null) {
            $status = $this->usageStatusExit;
        }
        $this->io->error($content, $status, false);
    }

    /**
     * For override
     */
    abstract protected function process();

    /**
     * For override
     *
     * @return bool
     */
    protected function loadOpts()
    {
        return true;
    }

    /**
     * Output
     *
     * @param string $message
     * @param bool $nl [optional]
     */
    final protected function out($message, $nl = true)
    {
        $this->io->write($message, $nl);
    }

    /**
     * Write to STDERR
     *
     * @param string $message
     * @param int $status [optional]
     * @param bool $nl [optional]
     */
    final protected function error($message, $status = null, $nl = true)
    {
        $this->io->error($message, $status, $nl);
    }

    /**
     * Silent read from STDIN
     *
     * @param string $prompt [optional]
     * @param bool $nl [optional]
     * @return string
     */
    final protected function silentRead($prompt = null, $nl = null)
    {
        if ($prompt !== null) {
            $this->io->write($prompt, false);
        }
        return $this->io->silentReadLine($nl);
    }

    /**
     * Reads entire STDIN
     *
     * @return string
     */
    final protected function readAll()
    {
        return $this->io->readAll();
    }

    /**
     * Reads the next line from STDIN
     *
     * @return string
     */
    final protected function readLine()
    {
        return $this->io->readLine();
    }

    /**
     * Sets the exit code of the process
     *
     * @param int $code
     */
    final protected function setStatus($code)
    {
        $this->io->setStatus($code);
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
     * @var int
     */
    protected $usageStatusExit = 1;

    /**
     * For override
     *
     * @var array
     */
    protected $optionsFormat = [];

    /**
     * @var string
     */
    protected $fileUsage = 'usage.txt';
}
