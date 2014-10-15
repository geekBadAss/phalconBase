<?php
/**
 * Profiler
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
class Profiler extends Singleton
{
    protected static $instance;

    private $profiles;
    private $enabled;

    const TYPE_DB = 'db';
    const TYPE_CACHE = 'cache';

    /**
     * constructor
     *
     * @return $this
     */
    public function __construct()
    {
        $this->profiles = array(
            self::TYPE_DB    => array(),
            self::TYPE_CACHE => array(),
        );
        $this->enabled = array(
            self::TYPE_DB    => true,
            self::TYPE_CACHE => false,
        );
    }

    /**
     * public function setEnabled
     *
     * @param string  $type    - profile type
     * @param boolean $boolean - true or false
     *
     * @return null
     */
    public function setEnabled($type, $boolean)
    {
        $this->enabled[$type] = $boolean;
    }

    /**
     * start
     *
     * @param string $type   - profile type
     * @param string $object - profiled object
     * @param string $notes  - notes pertaining to the profiled object
     *
     * @return int
     */
    public function start($type, $object, $notes = '')
    {
        if ($this->enabled[$type]) {
            $profileIndex = count($this->profiles[$type]);

            $this->profiles[$type][$profileIndex] = array(
                'object'      => $object,
                'notes'       => $notes,
                'started'     => microtime(true),
                'ended'       => null,
                'elapsedTime' => null,
                'result'      => null,
            );

            return $profileIndex;
        }

        return 0;
    }

    /**
     * end
     *
     * @param string $type         - profile type
     * @param int    $profileIndex - int returned by start function
     * @param int    $result       - result of process being profiled
     *
     * @return null
     */
    public function end($type, $profileIndex, $result = '')
    {
        if ($this->enabled[$type]) {
            $profile = $this->profiles[$type][$profileIndex];
            $profile['ended'] = microtime(true);
            $profile['elapsedTime'] = $profile['ended'] - $profile['started'];
            $profile['result'] = $result;

            $this->profiles[$type][$profileIndex] = $profile;
        }
    }

    /**
     * getProfiles
     *
     * @param string $type - profile type
     *
     * @return array
     */
    public function getProfiles($type)
    {
        return $this->profiles[$type];
    }

    /**
     * getCount
     *
     * @param string $type - profile type
     *
     * @return int
     */
    public function getCount($type)
    {
        return count($this->profiles[$type]);
    }

    /**
     * getTotalElapsedTime
     *
     * @param string $type - profile type
     *
     * @return number
     */
    public function getTotalElapsedTime($type)
    {
        $total = 0;
        foreach ($this->profiles[$type] as &$profile) {
            $total += $profile['elapsedTime'];
        }

        return $total;
    }

    /**
     * isEnabled
     *
     * @param string $type
     *
     * @return boolean
     */
    public function isEnabled($type)
    {
        return $this->enabled[$type];
    }
}
