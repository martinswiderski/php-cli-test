<?php

/**
 * One of three base classes of the test bench
 *
 * PHP version 5.5
 *
 * @category Core
 * @package  PhpCliTest
 * @author   Martin Swiderski <martin.swiderski@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @link     https://codebloke.wordpress.com/mit-license/
 */

namespace PhpCliTest;

/**
 * Assertion result object, implements $obj->toArray() and $obj->__toString() methods
 *
 * PHP version 5.5
 *
 * @category Result
 * @package  PhpCliTest
 * @author   Martin Swiderski <martin.swiderski@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @link     https://codebloke.wordpress.com/mit-license/
 */


class Result
{
    const ERR_TYPE_NON_PRIMITIVE
        = 'Type mismatch. At least one arguments is not a primitive';
    const MARGIN_LEFT            = '11';

    /**
     * Makes object immutable
     *
     * @var bool
     */
    private $_init = true;

    /**
     * Error
     *
     * @var bool|string
     */
    private $_error = false;

    /**
     * Assertion result
     *
     * @var bool
     */
    private $_result = false;

    /**
     * Comment
     *
     * @var string
     */
    private $_comment = '';

    /**
     * File calling the assertion
     *
     * @var string
     */
    private $_invoker = '';

    /**
     * Line in the file calling assertion
     *
     * @var int
     */
    private $_line = 0;

    /**
     * Sets results
     *
     * @param bool   $result  Assertion result
     * @param string $comment Comment text
     *
     * @return \PhpCliTest\Result
     */
    public function setResult($result, $comment)
    {
        if ($this->_init == true) {
            // set values passed
            $this->_result  = $result;
            $this->_comment = $comment;
            // infer line number and invoker
            $this->detectInvoker();
            $this->_init = false;
        }
        return $this;
    }

    /**
     * Detects invoker
     *
     * @return void
     */
    public function detectInvoker()
    {
        try {
            throw new \Exception('Ping');
        } catch (\Exception $xc) {
            $trace = $xc->getTrace();
            foreach ($trace as $id => $item) {
                if ($item['function'] === 'detectInvoker'
                    && $item['class'] === 'PhpCliTest\Result'
                ) {

                    $target = $trace[($id+2)];

                    $this->_line    = $target['line'];
                    $this->_invoker = $target['file'];
                    return;
                }
            }
            return;
        }
    }

    /**
     * Outputs object as formatted string
     *
     * @return string
     */
    public function __toString()
    {
        $output = array(
            str_pad('line ('.$this->_line.')', self::MARGIN_LEFT, ' ', STR_PAD_LEFT).
            ' '.(($this->_result === true) ? '      PASS : ' : '      FAIL : ').
            $this->_comment,
        );

        if (!is_bool($this->_error)) {
            $output[] = '                   ERR : '.$this->_error;
        }

        $output[] = '            Invoked by : '.$this->_invoker;
        $output[] = ' ';

        return join(PHP_EOL, $output);
    }

    /**
     * Returns result object as array
     *
     * @return array
     */
    public function asArray()
    {
        $out = array(
            'line'    => $this->_line,
            'comment' => $this->_comment,
            'result'  => ($this->_result===true) ? 'PASS' : 'FAIL',
            'invoker' => $this->_invoker
        );

        if (!is_bool($this->_error)) {
            $out['error'] = $this->_error;
        }
        return $out;
    }

    /**
     * Line number
     *
     * @return int
     */
    public function getLine()
    {
        return $this->_line;
    }

    /**
     * Gets error
     *
     * @return bool|string
     */
    public function getError()
    {
        return $this->_error;
    }


    /**
     * Sets error
     *
     * @param string $message Error message
     *
     * @return \PhpCliTest\Result
     */
    public function setError($message)
    {
        $this->_error = (string) $message;
        return $this;
    }

    /**
     * Invoker, filename
     *
     * @return string
     */
    public function getFile()
    {
        return $this->_invoker;
    }
    /**
     * Comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->_comment;
    }

    /**
     * Result
     *
     * @return bool
     */
    public function getResult()
    {
        return $this->_result;
    }





} 