<?php
/**
 * Singleton
 *
 * @package Lib
 * @author  aidan lydon <aidanlydon@gmail.com>
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
