<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace Documentation;

use RuntimeException;

class Pygmentize
{
    protected $pygmentize;

    public function __construct($pygmentizePath)
    {
        $this->pygmentize = $pygmentizePath;
    }

    public function transform($lexer, $code)
    {
        $lexer = strtolower($lexer);
        if ($lexer === 'bash') {
            $lexer = 'console';
        }

        $processDescription = array(
            0 => array('pipe', 'r'),
            1 => array('pipe', 'w'),
            2 => array('pipe', 'a'),
        );

        $command = sprintf('%s -l %s', $this->pygmentize, $lexer);

        $process = proc_open($command, $processDescription, $pipes);

        if (! is_resource($process)) {
            throw new RuntimeException('Unable to open process for pygmentize');
        }

        fwrite($pipes[0], $code);
        fclose($pipes[0]);

        $html = stream_get_contents($pipes[1]);
        fclose($pipes[1]);

        $errors = stream_get_contents($pipes[2]);
        fclose($pipes[2]);
        if (! empty($errors)) {
            throw new RuntimeException(
                'Error running pygmentize: %s',
                $errors
            );
        }

        return $html;
    }
}
