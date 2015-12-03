<?php
/**
 * @package \axy\cli\bin
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\cli\bin\io;

/**
 * Base implementation of IProcess
 */
abstract class Base implements IProcess
{
    /**
     * {@inheritdoc}
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * {@inheritdoc}
     */
    public function silentReadLine($nl = true)
    {
        $line = $this->readLine();
        $this->write(PHP_EOL, false);
        return $line;
    }

    /**
     * {@inheritdoc}
     */
    public function write($message, $nl = true)
    {
        $this->outOut($message.($nl ? PHP_EOL : ''));
    }

    /**
     * {@inheritdoc}
     */
    public function error($message, $status = null, $nl = true)
    {
        if ($status !== null) {
            $this->setStatus($status);
        }
        $this->outErr($message.($nl ? PHP_EOL : $nl));
    }

    /**
     * Writes a normal content
     *
     * @param string $content
     */
    abstract protected function outOut($content);

    /**
     * Writes an error content
     *
     * @param string $content
     */
    protected function outErr($content)
    {
        $this->outOut($content);
    }

    /**
     * @var int
     */
    protected $status = 0;
}
