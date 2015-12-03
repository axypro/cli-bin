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
            $result->error = 'empty argv';
            return $result;
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
                    $result->error = 'option '.$arg.' after argument';
                    return $result;
                }
                $len = strlen($arg);
                if ($len < 2) {
                    return null;
                }
                for ($i = 1; $i < $len; $i++) {
                    $o = substr($arg, $i, 1);
                    if (!isset($format[$o])) {
                        $result->error = 'illegal option -- '.$o;
                        return $result;
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
            $result->error = 'option requires an argument -- '.$wait;
            return $result;
        }
        return $result;
    }
}
