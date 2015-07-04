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
