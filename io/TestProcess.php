<?php
/**
 * @package \axy\cli\bin
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\cli\bin\io;

/**
 * Process implementation of tests
 */
class TestProcess extends Base
{
    /**
     * The constructor
     *
     * @param string[] $input
     *        an array list of the input lines
     */
    public function __construct(array $input = null)
    {
        $this->input = $input ?: [];
    }

    /**
     * {@inheritdoc}
     */
    protected function outOut($content)
    {
        $this->out[] = $content;
    }

    /**
     * {@inheritdoc}
     */
    protected function outErr($content)
    {
        $this->err[] = $content;
    }

    /**
     * {@inheritdoc}
     */
    public function readLine()
    {
        if (empty($this->input)) {
            return null;
        }
        return array_shift($this->input);
    }

    /**
     * {@inheritdoc}
     */
    public function readAll()
    {
        if (empty($this->input)) {
            return null;
        }
        $result = implode(PHP_EOL, $this->input).PHP_EOL;
        $this->input = [];
        return $result;
    }

    /**
     * @return string[]
     */
    public function getLinesOut()
    {
        return explode("\n", implode('', str_replace("\r", '', $this->out)));
    }

    /**
     * @return string[]
     */
    public function getLinesErr()
    {
        return explode("\n", implode('', str_replace("\r", '', $this->err)));
    }

    /**
     * @var string[]
     */
    private $input;

    /**
     * @var string[]
     */
    private $out = [];

    /**
     * @var string[]
     */
    private $err = [];
}
