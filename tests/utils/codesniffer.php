<?php

/**
 * Runs phpcs tests and outputs them into ./phpcs.txt
 *
 * PHP version 5.5
 *
 * @category TestExamples
 * @package  PhpCliTest
 * @author   Martin Swiderski <martin.swiderski@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @link     https://codebloke.wordpress.com/mit-license/
 */

$srcRoot     = realpath(__DIR__.'/../../').DIRECTORY_SEPARATOR;
$reportsDir  = realpath(__DIR__.'/../../reports').DIRECTORY_SEPARATOR;
$phpScripts  = explode("\n", trim(shell_exec("find {$srcRoot} -name \\*.php")));
$phpcsOutput = array();

foreach ($phpScripts as $file) {
    $file = trim($file);
    $expl = explode($srcRoot, $file);
    $phpcsOutput[]
        = '-------------------------------------'.
          '-------------------------------------------';
    $phpcsOutput[] = 'Filename : '.$expl[1];
    $phpcsOutput[] = 'SHA1     : ' . sha1_file($file);

    $phpcsExpl = explode("\n", trim(shell_exec("phpcs {$file}")));

    $lastExpl = count($phpcsExpl)-1;
    unset($phpcsExpl[0], $phpcsExpl[1], $phpcsExpl[$lastExpl]);
    if (isset($phpcsExpl[2])) {
        $phpcsExpl[2] = 'Defects  : ' . strtolower($phpcsExpl[2]);
    }

    foreach ($phpcsExpl as $line) {
        $phpcsOutput[] = rtrim($line);
    }
    $phpcsOutput[] = '';
}

file_put_contents($reportsDir.'/phpcs.txt', join(PHP_EOL, $phpcsOutput));
echo file_get_contents(__DIR__.'/phpcs.txt');
exit(0);


