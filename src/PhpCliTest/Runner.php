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
 * Singleton, a test runner
 *
 * PHP version 5.5
 *
 * @category Runner
 * @package  PhpCliTest
 * @author   Martin Swiderski <martin.swiderski@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @link     https://codebloke.wordpress.com/mit-license/
 */

class Runner
{

    const PHPCLITST_VERSION = 'PHP CLI Test v. 0.1';

    /**
     * Collection of tests executed
     *
     * @var array
     */
    public $tests = array();

    /**
     * Command line exit code
     *
     * @var int
     */
    public $exit_code = 0;

    /**
     * If TRUE first failure would break the test
     *
     * @var bool
     */
    public $break_at_first_failed = false;

    /**
     * Store for Singleton
     *
     * @var null|\PhpCliTest\Runner
     */
    private static $_self = null;

    /**
     * Constructor
     *
     * @return \PhpCliTest\Runner
     */
    private function __construct()
    {
    }

    /**
     * Hybrid getter/setter if set to TRUE breaks at first
     * assertion broken, otherwise it would evaluate all assertions
     * and send non-0 exit code at the end in case of failure
     *
     * @param null|bool $flag If TRUE it would break on failure
     *
     * @return bool
     */
    public function breakAtFailed($flag=null)
    {
        if (is_bool($flag)) {
            $this->break_at_first_failed = $flag;
        }
        return $this->break_at_first_failed;
    }

    /**
     * Hybrid setter/getter for exit code
     *
     * @param null|int $code Exit code, 0 or > 0
     *
     * @return int
     */
    public function exitCode($code=null)
    {
        if (is_numeric($code)) {
            $this->exit_code = (int) $code;
        }
        return $this->exit_code;
    }

    /**
     * Adds assertion result
     *
     * @param \PhpCliTest\Result $result Result object
     *
     * @return void
     */
    public function addTest(\PhpCliTest\Result $result)
    {
        $this->tests[] = $result;
    }

    /**
     * Singleton getter
     *
     * @return \PhpCliTest\Runner
     */
    public static function getInstance()
    {
        if (is_null(self::$_self)) {
            self::$_self = new \PhpCliTest\Runner();
        }
        return self::$_self;
    }

    /**
     * Returns all registered tests and their results as string
     *
     * @return string
     */
    public function present()
    {
        $output = array(
            self::PHPCLITST_VERSION,
            '',
        );

        if (!empty($this->tests)) {
            $output[] = 'Tests: ' . count($this->tests);
            $output[] = '';
            foreach ($this->tests as $id => $result_obj) {
                $output[] = (string) $result_obj;
                if (!is_bool($result_obj->getError())) {
                    $this->exitCode(1);
                }
            }
        } else {
            $output[] = 'No tests found.';
            $output[] = '';
        }
        $output[] = '';

        return PHP_EOL.join(PHP_EOL, $output);
    }

    /**
     * Returns results as JSON string
     *
     * @return string JSON
     */
    public function toJson()
    {
        $json = array(
            'testbench' => self::PHPCLITST_VERSION,
            'tests'     => count($this->tests),
            'status'    => null,
            'details'   => array()
        );

        foreach ($this->tests as $id => $result_obj) {
            $json['details'][] = $result_obj->asArray();
            if (!is_bool($result_obj->getError())) {
                $this->exitCode(1);
            }
        }

        $json['status'] = ($this->exitCode()==0) ? 'PASS' : 'FAIL';

        return PHP_EOL.json_encode($json, JSON_PRETTY_PRINT).PHP_EOL;
    }



} 