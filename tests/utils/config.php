<?php

/**
 * Configuration file defining autoloader and simple debugging function
 *
 * PHP version 5.5
 *
 * @category Configuration
 * @package  PhpCliTest
 * @author   Martin Swiderski <martin.swiderski@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @link     https://codebloke.wordpress.com/mit-license/
 */

/**
 * Initial definitions for resolving directories
 */

define(
    'DIRECTORY_TESTS',
    realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR
);

define(
    'DIRECTORY_CODE',
    realpath(
        DIRECTORY_TESTS.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'src'
    ).DIRECTORY_SEPARATOR
);

set_include_path(
    join(
        PATH_SEPARATOR,
        array_merge(
            explode(PATH_SEPARATOR, get_include_path()),
            array(
                DIRECTORY_TESTS,
                DIRECTORY_CODE
            )
        )
    )
);

/**
 * Auto-loads classes
 *
 * @param string $class Class to auto-load
 *
 * @return void
 */
function __autoload($class)
{
    include_once str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $class).'.php';
}

/**
 * Prints details and halts
 *
 * @param type $subject Item to inspect
 *
 * @return void
 */
function trap($subject)
{
    $cli = (!isset($_SERVER['HTTP_HOST'])) ? true : false;

    $data = array(
        'TYPE'       => gettype($subject),
        'CLASS'      => null,
        'DETAILS'    => print_r($subject, true),
        'VAR_DUMP'   => null,
        'TRACEROUTE' => null
    );

    try {
        throw new Exception("dummie");
    } catch (\Exception $ex) {
        $data['TRACEROUTE'] = $ex->getTraceAsString();
    }

    if ($data['TYPE']!=='object') {
        unset($data['CLASS']);
    } else {
        $data['CLASS'] = get_class($subject);
    }

    ob_start();
    var_dump($subject);
    $data['VAR_DUMP'] = ob_get_clean();

    $out = array();

    foreach ($data as $header => $string) {
        if ($cli) {
            $out[] = "\n";
            $out[] = "=========== {$header} ===========";
            $out[] = $string;
        } else {
            $out[] = "\n";
            $out[] = "<h2>{$header}</h2>";
            $out[] = "<pre>$string</pre>";
        }
    }

    echo join("\n", $out);
    exit();
}