<?php
/**
 * RS - iterable wrapper for phalcon pdo result set, so that I can use foreach (simpler)
 * instead of while ($resultSet->fetch)
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
class RS extends Base implements Iterator
{
    private $internal;
    private $position;
    private $current;
    private $valid;
    private $objectClass;

    /**
     * __construct
     *
     * @return $this
     */
    public function __construct()
    {
        $this->internal = null;
        $this->position = 0;
        $this->current = null;
        $this->valid = false;
    }

    /**
     * setInternal - set the internal result set object
     *
     * @param Phalcon\Db\Result\Pdo $rs          -
     * @param string                $objectClass -
     *
     * @return null
     */
    public function setInternal($rs, $objectClass)
    {
        $this->internal = $rs;
        $this->objectClass = $objectClass;
    }

    /**
     * rewind - back to the beginning of the resultSet, called when foreach starts
     *
     * @return null
     */
    public function rewind()
    {
        //executed before foreach
        $this->internal->dataSeek(0);
        $this->internal->setFetchMode(Phalcon\Db::FETCH_ASSOC);
        $this->position = 0;
        $this->_fetchAndValidate();
    }

    /**
     * current - get the current row, return value becomes the object inside the foreach
     *
     *  @return array/null
     */
    public function current()
    {
        if (!empty($this->objectClass)) {
            $ret = new $this->objectClass($this->current);
        } else {
            $ret = $this->current;
        }

        return $ret;
    }

    /**
     * key - get the current key, return value becomes the index inside the foreach
     *
     * @return int
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * next - iterate
     *
     * @return null
     */
    public function next()
    {
        $this->_fetchAndValidate();
        ++$this->position;
    }

    /**
     * valid - return value determines when the foreach will stop
     *
     * @return boolean
     */
    public function valid()
    {
        return $this->valid;
    }

    /**
     * _fetchAndValidate - fetch a row and validate it
     *
     * @return null
     */
    private function _fetchAndValidate()
    {
        $this->current = $this->internal->fetch();

        if (is_array($this->current) && !empty($this->current)) {
            $this->valid = true;
        } else {
            $this->valid = false;
        }
    }

    /**
     * toArray
     *
     * @return array
     */
    public function toArray()
    {
        $ret = array();

        foreach ($this as $row) {
            $ret[] = $row;
        }

        return $ret;
    }
}
