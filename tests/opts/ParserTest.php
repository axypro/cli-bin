<?php
/**
 * @package axy\cli\bin
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\cli\bin\tests\opts;

use axy\cli\bin\opts\Parser;

/**
 * coversDefaultClass axy\cli\bin\opts\Parser
 */
class ParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * covers ::getOption
     * @dataProvider providerParse
     * @param array $argv
     * @param array $format
     * @param array $expected
     */
    public function testParse($argv, $format, $expected)
    {
        $result = Parser::parse($argv, $format);
        if ($expected === null) {
            $this->assertNull($result);
        } else {
            $this->assertInstanceOf('axy\cli\bin\opts\Result', $result);
            foreach ($expected as $k => $v) {
                $this->assertSame($v, $result->$k, 'result->'.$k);
            }
        }
    }

    /**
     * @return array
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function providerParse()
    {
        return [
            [
                ['command', '-xa', '-c3', 'one', 'two'],
                [
                    'x' => false,
                    'a' => false,
                    'b' => false,
                    'c' => true,
                ],
                [
                    'command' => 'command',
                    'options' => [
                        'x' => true,
                        'a' => true,
                        'c' => '3',
                    ],
                    'args' => ['one', 'two'],
                ],
            ],
            [
                ['command', '-xa', '-c', 'one', 'two'],
                [
                    'x' => false,
                    'a' => false,
                    'b' => false,
                    'c' => true,
                ],
                [
                    'command' => 'command',
                    'options' => [
                        'x' => true,
                        'a' => true,
                        'c' => 'one',
                    ],
                    'args' => ['two'],
                ],
            ],
            [
                ['command', '-xac4', 'one', 'two'],
                [
                    'x' => false,
                    'a' => false,
                    'b' => false,
                    'c' => true,
                ],
                [
                    'command' => 'command',
                    'options' => [
                        'x' => true,
                        'a' => true,
                        'c' => '4',
                    ],
                    'args' => ['one', 'two'],
                ],
            ],
            [
                ['command', '-xac4', 'one', 'two'],
                [
                    'x' => false,
                    'a' => true,
                    'b' => false,
                    'c' => true,
                ],
                [
                    'command' => 'command',
                    'options' => [
                        'x' => true,
                        'a' => 'c4',
                    ],
                    'args' => ['one', 'two'],
                ],
            ],
            [
                ['command', '-xac4'],
                [
                    'x' => false,
                    'a' => true,
                    'b' => false,
                    'c' => true,
                ],
                [
                    'command' => 'command',
                    'options' => [
                        'x' => true,
                        'a' => 'c4',
                    ],
                    'args' => [],
                ],
            ],
            [
                ['command', 'two'],
                [
                    'x' => false,
                    'a' => true,
                    'b' => false,
                    'c' => true,
                ],
                [
                    'command' => 'command',
                    'options' => [],
                    'args' => ['two'],
                ],
            ],
            [
                ['command', '-xac4', 'one', '-b', 'two'],
                [
                    'x' => false,
                    'a' => false,
                    'b' => false,
                    'c' => true,
                ],
                null,
            ],
            [
                ['command', '-xad', 'one', 'two'],
                [
                    'x' => false,
                    'a' => false,
                    'b' => false,
                    'c' => true,
                ],
                null,
            ],
            [
                ['command', '-ac'],
                [
                    'x' => false,
                    'a' => false,
                    'b' => false,
                    'c' => true,
                ],
                null,
            ],
            [
                [],
                [
                    'x' => false,
                    'a' => false,
                    'b' => false,
                    'c' => true,
                ],
                null,
            ],
        ];
    }
}
