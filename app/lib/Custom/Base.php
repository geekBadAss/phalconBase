<?php
/**
 * Base - base implementation of php magic methods
 *
 * @package Lib
 * @author  aidan lydon <aidanlydon@gmail.com>
 */
class Base
{
    /**
     * __construct
     *
     * @param array $params
     *
     * @return $this
     */
    public function __construct(array $params = null)
    {
        if (is_array($params) && !empty($params)) {
            foreach ($params as $key => &$value) {
                $this->{$key} = $value;
            }
        }

        return $this;
    }

    /**
     * __destruct
     *
     * @return null
     */
    public function __destruct()
    {

    }

    /**
     * __call
     *
     * @param string $function - function name
     * @param array  $args     - function arguments
     *
     * @return null
     */
    public function __call($function, $args)
    {
        throw new Exception(
            'attempting to call undefined function: ' . $function . ' with args: ' .
            print_r($args, true) . ' on class: ' . get_class($this)
        );
    }

    /**
     * __callStatic
     *
     * @param string $function - function name
     * @param array  $args     - function arguments
     *
     * @return null
     */
    public static function __callStatic($function, $args)
    {
        throw new Exception(
            'attempting to call undefined static function: ' . $function . ' with args: ' .
            print_r($args, true) . ' on class: ' . get_called_class()
        );
    }

    /**
     * __get
     *
     * @param string $member - data member name
     *
     * @return mixed - data member value
     */
    public function __get($member)
    {
        return $this->{$member};
    }

    /**
     * __set
     *
     * @param string $member - data member name
     * @param mixed  $value  - data member value
     *
     * @return null
     */
    public function __set($member, $value)
    {
        $this->{$member} = $value;
    }

    /**
     * __isset
     *
     * @param string $member
     *
     * @return boolean
     */
    public function __isset($member)
    {
        return isset($this->{$member});
    }

    /**
     * __unset
     *
     * @param string $member
     *
     * @return null
     */
    public function __unset($member)
    {
        $this->{$member} = null;
    }

    /**
     * __sleep - defines which object data members are serialized. Called when storing objects in
     * memcached. For the purpose of a base class implementation, serialize everything that isn't
     * static. If a child class includes data members that are resources, override this function and
     * exclude them.
     *
     * @return array
     */
    public function __sleep()
    {
        $members = get_object_vars($this);
        return array_keys($members);
    }

    /**
     * __wakeup - for reconstructing resource data members when unserializing an object. Called when
     * getting an object from memcached.
     *
     * @return null
     */
    public function __wakeup()
    {

    }

    /**
     * __toString
     *
     * @return string
     */
    public function __toString()
    {
        return print_r($this, true);
    }

    /**
     * __invoke - called when a script tries to call an object as a function
     *
     * @return null
     */
    public function __invoke()
    {
        throw new Exception('__invoke called on class: ' . get_called_class());
    }

    /**
     * __set_state
     *
     * @param array $properties
     *
     * @return null
     */
    public static function __set_state(array $properties)
    {
        throw new Exception('__set_state called on class: ' . get_called_class());

        $class = get_called_class();
        return new $class($properties);
    }

    /**
     * __clone
     *
     * @return null
     */
    public function __clone()
    {

    }

    /**
     * __debugInfo - called by var_dump (added in 5.6)
     *
     * @return array
     *
    public function __debugInfo()
    {

    }*/

    /**
     * toArray
     *
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }
}
