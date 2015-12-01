<?php
/**
 * @package axy\cli\bin
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\cli\bin\opts;

/**
 * Result of CLI arguments parsing
 *
 * For example: htpasswd -nbB -C5 user password
 * command: htpasswd
 * options: {n: true, b: true, B: true, C: 5}
 * args: [user, password]
 */
class Result
{
    /**
     * @var string
     */
    public $command;

    /**
     * @var array
     */
    public $options = [];

    /**
     * @var string[]
     */
    public $args = [];

    /**
     * Returns the option value
     *
     * @param string $name
     * @param mixed $default [optional]
     * @return mixed
     */
    public function getOption($name, $default = null)
    {
        return isset($this->options[$name]) ? $this->options[$name] : $default;
    }

    /**
     * Returns the next argument or NULL if arguments are ended
     *
     * @return string
     */
    public function getNextArgument()
    {
        if (empty($this->args)) {
            return null;
        }
        return array_shift($this->args);
    }
}
