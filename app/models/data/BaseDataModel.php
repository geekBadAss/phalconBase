<?php
/**
 * BaseDataModel - provides protected functions to call from child classes for handling db
 *  interaction and exception logging to make the child classes simpler
 *
 * @package DataModels
 * @author  aidan lydon <aidanlydon@gmail.com>
 */
class BaseDataModel extends Base
{
    /**
     * _getAll - get multiple rows
     *
     * @param string $sql   - sql statement
     * @param array  $bind  - bind variables
     * @param array  $class - class of objects to populate
     *
     * @return false / iterable RS object that hydrates $class objects when iterated (or arrays if
     *  $class is null)
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
     * _find - get one row
     *
     * @param string $sql   - sql statement
     * @param array  $bind  - bind variables
     * @param array  $class - class of object to populate
     *
     * @return false / $class object / array (if $class is null)
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

    /**
     * _getCol
     *
     * @param string $sql  - sql statement
     * @param array  $bind - bind variables
     *
     * @return array
     */
    protected static function _getCol($sql, $bind = array())
    {
        $ret = false;

        try {
            $db = DB::getConnection();

            $ret = $db->getCol($sql, $bind);

        } catch (Exception $e) {
            //@codeCoverageIgnoreStart
            xlog($e);
            //@codeCoverageIgnoreEnd
        }

        return $ret;
    }
}
