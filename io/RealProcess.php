<?php
/**
 * @package \axy\cli\bin
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\cli\bin\io;

/**
 * Process i/o implementation
 */
class RealProcess extends Base
{
    /**
     * {@inheritdoc}
     */
    public function readLine()
    {
        return fgets(STDIN);
    }

    /**
     * {@inheritdoc}
     */
    public function readAll()
    {
        return stream_get_contents(STDIN);
    }

    /**
     * {@inheritdoc}
     */
    public function silentReadLine($nl = true)
    {
        if (substr(strtolower(PHP_OS), 0, 3) === 'win') {
            return $this->readLine();
        }
        ob_start();
        $result = system('/usr/bin/env bash -c "read -s -r pass && echo \$pass" 2>&1', $status);
        ob_end_clean();
        if ((int)$status !== 0) {
            return $this->readLine();
        }
        if ($nl) {
            $this->outOut(PHP_EOL);
        }
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    protected function outOut($content)
    {
        fwrite(STDOUT, $content);
    }

    /**
     * {@inheritdoc}
     */
    protected function outErr($content)
    {
        fwrite(STDERR, $content);
    }
}
