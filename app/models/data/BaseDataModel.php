<?php
/**
 * BaseDataModel
 *
 * PHP Version 5.3
 *
 * @package   DataModels
 * @author    aidan lydon <alyo@loc.gov>
 * @copyright 2014 The Library of Congress
 * @license   Copyright 2014 The Library of Congress
 * @version   $Id:$
 * @link      TBD
 * @since     Sept 24, 2014
 */
class BaseDataModel extends Base
{
    /**
     * _getAll
     *
     * @param string $sql   - sql statement
     * @param array  $bind  - bind variables
     * @param array  $class - class of objects to populate
     *
     * @return false / array of $class objects / array (if $class is null)
     */
    protected static function _getAll($sql, $bind = array(), $class = null)
    {
        $ret = false;

        try {
            $db = DB::getConnection();

            $ret = $db->getAll($sql, $bind, $class);

        } catch (Exception $e) {
            //@codeCoverageIgnoreStart
            xlog($e);
            //@codeCoverageIgnoreEnd
        }

        return $ret;
    }

    /**
     * _find
     *
     * @param string $sql   - sql statement
     * @param array  $bind  - bind variables
     * @param array  $class - class of object to populate
     *
     * @return false/$class object
     */
    protected static function _find($sql, $bind = array(), $class = null)
    {
        $ret = false;

        try {
            $db = DB::getConnection();

            $row = $db->getRow($sql, $bind);

            if (!empty($row)) {
                if (is_null($class)) {
                    $ret = $row;
                } else {
                    $ret = new $class($row);
                }
            }

        } catch (Exception $e) {
            //@codeCoverageIgnoreStart
            xlog($e);
            //@codeCoverageIgnoreEnd
        }

        return $ret;
    }

    /**
     * _insert
     *
     * @param string $sql  - sql statement
     * @param array  $bind - bind variables
     *
     * @return false/int
     */
    protected function _insert($sql, $bind)
    {
        $ret = false;

        try {
            $db = DB::getConnection();

            //insert
            $db->execute($sql, $bind);

            //return the inserted id
            $ret = $db->insertId();

        } catch (Exception $e) {
            //@codeCoverageIgnoreStart
            xlog($e);
            //@codeCoverageIgnoreEnd
        }

        return $ret;
    }

    /**
     * _update
     *
     * @param string $sql  - sql statement
     * @param array  $bind - bind variables
     *
     * @return false/int
     */
    protected function _update($sql, $bind)
    {
        $ret = false;

        try {
            $db = DB::getConnection();

            //update
            $db->execute($sql, $bind);

            //return the number of affected rows
            $ret = $db->affectedRows();

        } catch (Exception $e) {
            //@codeCoverageIgnoreStart
            xlog($e);
            //@codeCoverageIgnoreEnd
        }

        return $ret;
    }

    /**
     * _delete
     *
     * @param string $sql  - sql statement
     * @param array  $bind - bind variables
     *
     * @return false/int
     */
    protected function _delete($sql, $bind)
    {
        return $this->_update($sql, $bind);
    }

    /**
     * _getOne
     *
     * @param string $sql  - sql statement
     * @param array  $bind - bind variables
     *
     * @return int/string
     */
    protected static function _getOne($sql, $bind = array())
    {
        $ret = false;

        try {
            $db = DB::getConnection();

            $ret = $db->getOne($sql, $bind);

        } catch (Exception $e) {
            //@codeCoverageIgnoreStart
            xlog($e);
            //@codeCoverageIgnoreEnd
        }

        return $ret;
    }

    /**
     * _getAssoc
     *
     * @param string $sql  - sql statement
     * @param array  $bind - bind variables
     *
     * @return array
     */
    protected static function _getAssoc($sql, $bind = array())
    {
        $ret = false;

        try {
            $db = DB::getConnection();

            $ret = $db->getAssoc($sql, $bind);

        } catch (Exception $e) {
            //@codeCoverageIgnoreStart
            xlog($e);
            //@codeCoverageIgnoreEnd
        }

        return $ret;
    }
}
