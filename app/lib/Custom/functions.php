<?php
/**
 * functions
 *
 * PHP Version 5.3
 *
 * @package   Lib
 * @author    aidan lydon <alyo@loc.gov>
 * @copyright 2014 The Library of Congress
 * @license   Copyright 2014 The Library of Congress
 * @version   $Id:$
 * @link      TBD
 * @since     Sept 24, 2014
 */

/**
 * pre
 *
 * @param mixed   $var  - the variable to dump
 * @param boolean $exit - whether or not to cease execution
 *
 * @return null
 */
function pre($var, $exit = false)
{
    //TODO: this should do nothing in production environments

    if (!isset($_SERVER['REMOTE_ADDR'])) {
        //command line
        var_dump($var);
    } else {
        //web server
        echo '<link rel="stylesheet" type="text/css" href="/css/debug.css" /><pre class="debug">';

        $debug = debug_backtrace();

        if (isset($debug[0]['file'])) {
            echo '<p>file: ' . $debug[0]['file'] . '<br>line: ' . $debug[0]['line'] . '</p>';
        }

        switch (gettype($var)) {
        case 'boolean':
            var_dump($var);
            break;
        case 'NULL':
            echo 'null';
            break;
        default:
            print_r($var);
            break;
        }

        echo '</pre>';
    }

    if ($exit) {
        die();
    }
}

/**
 * xlog - log something to the ExceptionLog table
 *
 * @param mixed  $exception - the exception object
 * @param string $location  - the location where the exception was thrown
 *
 * @return int
 */
function xlog($exception, $location = '')
{
    return ExceptionLog::log($exception, $location);
}

/**
 * out
 *
 * @param mixed $var
 *
 * @return null
 */
function out($var)
{
    return str_replace(array('&gt;', '&lt;'), array('>', '<'), htmlentities(trim($var)));
}

/**
 * validateEmailAddress
 *
 * @param string $email
 *
 * @return boolean
 */
function validEmailAddress($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}
