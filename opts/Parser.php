<?php
/**
 * @package axy\cli\bin
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\cli\bin\opts;

/**
 * CLI arguments parser
 */
class Parser
{
    /**
     * Parses a command line arguments
     *
     * Format: allowed options
     * name => false (flag) / true (required value)
     *
     * @param string[] $argv
     * @param array $format
     * @return \axy\cli\bin\opts\Result
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public static function parse(array $argv, array $format)
    {
        $result = new Result();
        if (empty($argv)) {
            return null;
        }
        $result->command = array_shift($argv);
        $pArgs = false;
        $wait = null;
        foreach ($argv as $arg) {
            if ($wait) {
                $result->options[$wait] = $arg;
                $wait = null;
                continue;
            }
            if (substr($arg, 0, 1) === '-') {
                if ($pArgs) {
                    return null;
                }
                $len = strlen($arg);
                if ($len < 2) {
                    return null;
                }
                for ($i = 1; $i < $len; $i++) {
                    $o = substr($arg, $i, 1);
                    if (!isset($format[$o])) {
                        return null;
                    }
                    if ($format[$o]) {
                        if ($i < $len - 1) {
                            $result->options[$o] = substr($arg, $i + 1);
                        } else {
                            $wait = $o;
                        }
                        break;
                    } else {
                        $result->options[$o] = true;
                    }
                }
            } else {
                $pArgs = true;
                $result->args[] = $arg;
            }
        }
        if ($wait !== null) {
            return null;
        }
        return $result;
    }
}
