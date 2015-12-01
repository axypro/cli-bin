<?php
/**
 * @package \axy\cli\bin
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\cli\bin\io;

/**
 * Interface of a process (i/o streams and status code)
 */
interface IProcess
{
    /**
     * Sets the exit code of the process
     *
     * @param int $status
     */
    public function setStatus($status);

    /**
     * Returns the exit code of the process
     *
     * @return int
     */
    public function getStatus();

    /**
     * Writes a message to the STDOUT
     *
     * @param string $message
     * @param bool $nl [optional]
     *        new line
     */
    public function write($message, $nl = true);

    /**
     * Writes a message to the STDERR
     *
     * @param string $message
     * @param int $status [optional]
     *        set the result code
     * @param bool $nl [optional]
     *        new line
     */
    public function error($message, $status = null, $nl = true);

    /**
     * Reads a line from the STDIN
     *
     * @return string
     */
    public function readLine();

    /**
     * Reads the all content from the STDIN
     *
     * @return string
     */
    public function readAll();

    /**
     * Silent read a line from the STDIN (for passwords)
     *
     * @param bool $nl [optional]
     *        add new line after input
     * @return string
     */
    public function silentReadLine($nl = true);
}
