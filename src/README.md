# Documentation

## `namespace PhpCliTest`

One of three base classes of the test bench 

PHP version 5.5

 * **Package:** PhpCliTest
 * **Author:** Martin Swiderski <martin.swiderski@gmail.com>
 * **License:** http://opensource.org/licenses/MIT MIT
 * **Link:** https://codebloke.wordpress.com/mit-license/

## `class Result`

Assertion result object, implements $obj->toArray() and $obj->__toString() methods 

PHP version 5.5

 * **Package:** PhpCliTest
 * **Author:** Martin Swiderski <martin.swiderski@gmail.com>
 * **License:** http://opensource.org/licenses/MIT MIT
 * **Link:** https://codebloke.wordpress.com/mit-license/

## `private $_init = true`

Makes object immutable


## `private $_error = false`

Error


## `private $_result = false`

Assertion result


## `private $_comment = ''`

Comment


## `private $_invoker = ''`

File calling the assertion


## `private $_line = 0`

Line in the file calling assertion


## `public function setResult($result, $comment)`

Sets results

 * **Parameters:**
   * `bool` — $result Assertion result
   * `string` — $comment Comment text
 * **Returns:** \PhpCliTest\Result

## `public function detectInvoker()`

Detects invoker

 * **Returns:** void

## `public function __toString()`

Outputs object as formatted string

 * **Returns:** string

## `public function asArray()`

Returns result object as array

 * **Returns:** array

## `public function getLine()`

Line number

 * **Returns:** int

## `public function getError()`

Gets error

 * **Returns:** bool|string

## `public function setError($message)`

Sets error

 * **Parameters:** `string` — $message Error message
 * **Returns:** \PhpCliTest\Result

## `public function getFile()`

Invoker, filename

 * **Returns:** string

## `public function getComment()`

Comment

 * **Returns:** string

## `public function getResult()`

Result

 * **Returns:** bool

## `class Runner`

Singleton, a test runner

PHP version 5.5

 * **Package:** PhpCliTest
 * **Author:** Martin Swiderski <martin.swiderski@gmail.com>
 * **License:** http://opensource.org/licenses/MIT MIT
 * **Link:** https://codebloke.wordpress.com/mit-license/

## `public $tests = array()`

Collection of tests executed


## `public $exit_code = 0`

Command line exit code


## `public $break_at_first_failed = false`

If TRUE first failure would break the test


## `private static $_self = null`

Store for Singleton


## `private function __construct()`

Constructor

 * **Returns:** \PhpCliTest\Runner

## `public function breakAtFailed($flag=null)`

Hybrid getter/setter if set to TRUE breaks at first assertion broken, otherwise it would evaluate all assertions and send non-0 exit code at the end in case of failure

 * **Parameters:** `null|bool` — $flag If TRUE it would break on failure
 * **Returns:** bool

## `public function exitCode($code=null)`

Hybrid setter/getter for exit code

 * **Parameters:** `null|int` — $code Exit code, 0 or > 0
 * **Returns:** int

## `public function addTest(\PhpCliTest\Result $result)`

Adds assertion result

 * **Parameters:** `\PhpCliTest\Result` — $result Result object
 * **Returns:** void

## `public static function getInstance()`

Singleton getter

 * **Returns:** \PhpCliTest\Runner

## `public function present()`

Returns all registered tests and their results as string

 * **Returns:** string

## `public function toJson()`

Returns results as JSON string

 * **Returns:** string JSON

 