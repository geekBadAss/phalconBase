<?php
/**
 * Singleton
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
class Singleton
{
    /**
     * getInstance
     *
     * @return static instance
     */
    public static function getInstance()
    {
        //NOTE: $instance (and __construct) must be declared protected in child class

        if (is_null(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}
