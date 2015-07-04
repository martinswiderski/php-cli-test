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
 * A test case with assertions
 *
 * PHP version 5.5
 *
 * @category TestCase
 * @package  PhpCliTest
 * @author   Martin Swiderski <martin.swiderski@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @link     https://codebloke.wordpress.com/mit-license/
 */

class TestCase
{
    /**
     * Asserts if two variables are equal
     *
     * @param mixed  $given    Given value
     * @param mixed  $expected Expected value
     * @param string $comment  Assertion comment
     *
     * @return \PhpCliTest\Result
     */
    public function assertEqual($given, $expected, $comment)
    {
        $result = (!$this->isPrimitive($given) || !$this->isPrimitive($expected))
                  ? $this->result()->setResult(false, $comment)
                      ->setError(\PhpCliTest\Result::ERR_TYPE_NON_PRIMITIVE)
                  : $this->result()->setResult(($given == $expected), $comment);

        $this->runner()->addTest($result);

        return $result;
    }

    /**
     * Asserts if two variables are NOT equal
     *
     * @param mixed  $given    Given value
     * @param mixed  $expected Expected value
     * @param string $comment  Assertion comment
     *
     * @return \PhpCliTest\Result
     */
    public function assertNotEqual($given, $expected, $comment)
    {
        $result = (!$this->isPrimitive($given) || !$this->isPrimitive($expected))
            ? $this->result()->setResult(false, $comment)
                ->setError(\PhpCliTest\Result::ERR_TYPE_NON_PRIMITIVE)
            : $this->result()->setResult(($given != $expected), $comment);

        $this->runner()->addTest($result);

        return $result;
    }

    /**
     * Asserts if two variables are identical
     *
     * @param mixed  $given    Given value
     * @param mixed  $expected Expected value
     * @param string $comment  Assertion comment
     *
     * @return \PhpCliTest\Result
     */
    public function assertIdentical($given, $expected, $comment)
    {
        if (!$this->isPrimitive($given) || !$this->isPrimitive($expected)) {
            // hash
            $given    = $this->hash($given);
            $expected = $this->hash($expected);
        }

        $result = $this->result()->setResult(($given === $expected), $comment);

        $this->runner()->addTest($result);

        return $result;
    }

    /**
     * Creates hash of an object or array
     *
     * @param mixed $non_primitive Non primitive to hash
     *
     * @return string MD5
     */
    public function hash($non_primitive)
    {
        return md5(print_r($non_primitive, true));
    }

    /**
     * Asserts if two variables are NOT identical
     *
     * @param mixed  $given    Given value
     * @param mixed  $expected Expected value
     * @param string $comment  Assertion comment
     *
     * @return \PhpCliTest\Result
     */
    public function assertNotIdentical($given, $expected, $comment)
    {
        if (!$this->isPrimitive($given) || !$this->isPrimitive($expected)) {
            // hash
            $given    = $this->hash($given);
            $expected = $this->hash($expected);
        }

        $result = $this->result()->setResult(($given !== $expected), $comment);

        $this->runner()->addTest($result);

        return $result;
    }

    /**
     * Asserts if variable is of expected type
     *
     * @param mixed  $variable Inspected variable
     * @param string $type     Expected type
     * @param string $comment  Assertion comment
     *
     * @return \PhpCliTest\Result
     */
    public function assertIsOfType($variable, $type, $comment)
    {
        $result = $this->result();
        if ($this->isPrimitive($type)) {
            $result->setResult(
                (strtolower(gettype($variable)) === strtolower($type)),
                $comment
            );
        } else {
            $result->setResult(false, $comment)
                ->setError(\PhpCliTest\Result::ERR_TYPE_NON_PRIMITIVE);
        }

        $this->runner()->addTest($result);

        return $result;
    }

    /**
     * Asserts if one string contains the other
     *
     * @param string $haystack String to search in
     * @param string $needle   Searched string
     * @param string $comment  Assertion comment
     *
     * @return \PhpCliTest\Result
     */
    public function assertContainsString($haystack, $needle, $comment)
    {
        $result = $this->result();
        if ($this->isPrimitive($haystack) && $this->isPrimitive($needle)) {
            $result->setResult(
                !is_bool(strpos($haystack, $needle)),
                $comment
            );
        } else {
            $result->setResult(false, $comment)
                ->setError(\PhpCliTest\Result::ERR_TYPE_NON_PRIMITIVE);
        }

        $this->runner()->addTest($result);

        return $result;
    }

    /**
     * Asserts if one string contains the other
     * Here search is not case sensitive
     *
     * @param string $haystack String to search in
     * @param string $needle   Searched string
     * @param string $comment  Assertion comment
     *
     * @return \PhpCliTest\Result
     */
    public function assertContainsStringIgnoreCase($haystack, $needle, $comment)
    {
        $haystack = strtolower($haystack);
        $needle   = strtolower($needle);

        $result = $this->result();
        if ($this->isPrimitive($haystack) && $this->isPrimitive($needle)) {
            $result->setResult(
                !is_bool(strpos($haystack, $needle)),
                $comment
            );
        } else {
            $result->setResult(false, $comment)
                ->setError(\PhpCliTest\Result::ERR_TYPE_NON_PRIMITIVE);
        }

        $this->runner()->addTest($result);

        return $result;
    }

    /**
     * Checks if variable is a primitive
     *
     * @param mixed $variable Inspected variable
     *
     * @return bool
     */
    public function isPrimitive($variable)
    {
        return !in_array(
            true,
            array(is_object($variable), is_array($variable), is_resource($variable)),
            true
        );
    }

    /**
     * Gets instance of result object
     *
     * @return \PhpCliTest\Result
     */
    public function result()
    {
        return new \PhpCliTest\Result();
    }

    /**
     * Gets reference to runner object
     *
     * @return \PhpCliTest\Runner
     */
    public function runner()
    {
        return \PhpCliTest\Runner::getInstance();
    }

} 