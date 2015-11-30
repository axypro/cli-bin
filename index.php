<?php
/**
 * Helper for creating console utilities
 *
 * @package axy\cli\bin
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 * @license https://raw.github.com/axypro/cli-bin/master/LICENSE MIT
 * @link https://github.com/axypro/cli-bin repository
 * @link https://packagist.org/packages/axy/cli-bin composer package
 * @uses PHP5.4+
 */

namespace axy\cli\bin;

if (!is_file(__DIR__.'/vendor/autoload.php')) {
    throw new \LogicException('Please: composer install');
}

require_once(__DIR__.'/vendor/autoload.php');
