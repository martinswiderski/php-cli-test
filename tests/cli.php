<?php

/**
 * Command-line example running all tests
 * and outputting them into STDIN returning
 * non-zero exit code on any test failing
 *
 * PHP version 5.5
 *
 * @category TestExamples
 * @package  PhpCliTest
 * @author   Martin Swiderski <martin.swiderski@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @link     https://codebloke.wordpress.com/mit-license/
 */

require_once 'utils/config.php';          // This only defines your auto-loader
                                    // so you can skip it if you have your own
$test = new \PhpCliTest\TestCase(); // Constructor followed by tests

// ----------------- actual tests -----------------------

$test->assertIsOfType(
    new ArrayObject(array(2)), // given
    'object',                  // expected
    'Are objects'              // comment
);

$obj1 = new ArrayObject(array(1 => 3));
$obj2 = $obj1;

$test->assertIdentical(
    $obj1,
    $obj2,
    'Objects are identical'
);

$test->assertEqual(
    123,                       // given
    new ArrayObject(array(2)), // expected
    'Are equal'                // comment
);

// ----------------- output -----------------------------

echo $test->runner()->present();   // output
exit($test->runner()->exitCode()); // exit code
