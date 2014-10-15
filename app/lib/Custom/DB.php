<?php
/**
 * DB - db wrapper with query profiling
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
class DB extends Singleton
{
    protected static $instance;

    private $db;
    private $profiler;
    private $profilerEnabled;
    private $profileType;

    /**
     * getConnection - get the database connection
     *
     * @return DB singleton instance
     */
    public static function getConnection()
    {
        return static::getInstance();
    }

    /**
     * disconnect
     *
     * @return null
     */
    public static function disconnect()
    {
        $instance = static::getInstance();
        $instance->db->close();
    }

    /**
     * constructor
     *
     * @return DB
     */
    public function __construct()
    {
        try {
            $this->profiler = Profiler::getInstance();
            $this->profileType = Profiler::TYPE_DB;

            $this->profilerEnabled = $this->profiler->isEnabled(
                $this->profileType
            );

            $this->db = Phalcon\DI::getDefault()->get('db');

        } catch (Exception $e) {
            //db connection failed
            var_dump($e);
            die();
        }

        return $this;
    }

    /**
     * execute
     *
     * @param string $sql   - sql statement
     * @param array  $bind  - bind variables
     * @param string $notes - profiler notes
     *
     * @return boolean
     */
    public function execute($sql, $bind = null, $notes = '')
    {
        if ($this->profilerEnabled) {
            $profileId = $this->_startProfile($sql, $bind, $notes);

            $ret = $this->db->execute($sql, $bind);

            $this->_endProfile($profileId, '');//$ret->NumRows();

        } else {
            $ret = $this->db->execute($sql, $bind);
        }

        return $ret;
    }

    /**
     * _query
     *
     * @param string $sql  - sql query
     * @param array  $bind - bind variables
     *
     * @return Phalcon\Db\Result\Pdo
     */
    private function _query($sql, $bind = null)
    {
        $result = $this->db->query($sql, $bind);
        $result->setFetchMode(\Phalcon\Db::FETCH_ASSOC);

        return $result;
    }

    /**
     * getAll
     *
     * @param string $sql         - sql statement
     * @param array  $bind        - bind variables
     * @param string $objectClass - class name of object to hydrate and return during iteration
     * @param string $notes       - profiler notes
     *
     * @return array
     */
    public function getAll($sql, $bind = null, $objectClass = '', $notes = '')
    {
        $ret = new RS;

        if ($this->profilerEnabled) {
            $profileId = $this->_startProfile($sql, $bind, $notes);

            $ret->setInternal($this->_query($sql, $bind), $objectClass);

            $this->_endProfile($profileId, $this->affectedRows());

        } else {
            $ret->setInternal($this->_query($sql, $bind), $objectClass);
        }

        return $ret;
    }

    /**
     * _getAll
     *
     * @param string $sql  -
     * @param array  $bind -
     *
     * @return ?
     */
    private function _getAll($sql, $bind = null)
    {
        return $this->db->fetchAll($sql, \Phalcon\Db::FETCH_ASSOC, $bind);
    }

    /**
     * getAssoc
     *
     * @param string $sql   - sql statement
     * @param array  $bind  - bind variables
     * @param string $notes - profiler notes
     *
     * @return array
     */
    public function getAssoc($sql, $bind = null, $notes = '')
    {
        if ($this->profilerEnabled) {
            $profileId = $this->_startProfile($sql, $bind, $notes);

            $ret = $this->_getAssoc($sql, $bind);

            $this->_endProfile($profileId, count($ret));

        } else {
            $ret = $this->_getAssoc($sql, $bind);
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
    private function _getAssoc($sql, $bind = null)
    {
        $ret = array();

        $rows = $this->_getAll($sql, $bind);

        if (!empty($rows)) {
            $keys = array_keys($rows[0]);

            foreach ($rows as &$row) {
                $ret[$row[$keys[0]]] = $row[$keys[1]];
            }
        }

        return $ret;
    }

    /**
     * getCol
     *
     * @param string $sql   - sql statement
     * @param array  $bind  - bind variables
     * @param string $notes - profiler notes
     *
     * @return array
     */
    public function getCol($sql, $bind = null, $notes = '')
    {
        if ($this->profilerEnabled) {
            $profileId = $this->_startProfile($sql, $bind, $notes);

            $ret = $this->_getCol($sql, $bind);

            $this->_endProfile($profileId, count($ret));

        } else {
            $ret = $this->_getCol($sql, $bind);
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
    private function _getCol($sql, $bind = null)
    {
        $ret = array();

        $rows = $this->_getAll($sql, $bind);

        if (!empty($rows)) {
            $keys = array_keys($rows[0]);

            foreach ($rows as &$row) {
                $ret[] = $row[$keys[0]];
            }
        }

        return $ret;
    }

    /**
     * getOne
     *
     * @param string $sql   - sql statement
     * @param array  $bind  - bind variables
     * @param string $notes - profiler notes
     *
     * @return array
     */
    public function getOne($sql, $bind = null, $notes = '')
    {
        if ($this->profilerEnabled) {
            $profileId = $this->_startProfile($sql, $bind, $notes);

            $ret = $this->_getOne($sql, $bind);

            $this->_endProfile($profileId, count($ret));

        } else {
            $ret = $this->_getOne($sql, $bind);
        }

        return $ret;
    }

    /**
     * _getOne
     *
     * @param string $sql  - sql statement
     * @param array  $bind - bind variables
     *
     * @return mixed
     */
    private function _getOne($sql, $bind = null)
    {
        $values = $this->db->fetchOne($sql, Phalcon\Db::FETCH_NUM, $bind);
        return $values[0];
    }

    /**
     * getRow
     *
     * @param string $sql   - sql statement
     * @param array  $bind  - bind variables
     * @param string $notes - profiler notes
     *
     * @return array
     */
    public function getRow($sql, $bind = null, $notes = '')
    {
        if ($this->profilerEnabled) {
            $profileId = $this->_startProfile($sql, $bind, $notes);

            $ret = $this->_getRow($sql, $bind);

            $this->_endProfile($profileId, !empty($ret));

        } else {
            $ret = $this->_getRow($sql, $bind);
        }

        return $ret;
    }

    /**
     * _getRow
     *
     * @param string $sql  -
     * @param array  $bind -
     *
     * @return array
     */
    private function _getRow($sql, $bind = null)
    {
        $sql = $this->db->limit($sql, 1);
        $object = $this->_query($sql, $bind);

        return $object->fetchArray();
    }

    /**
     * insertId
     *
     * @return int - inserted id
     */
    public function insertId()
    {
        return $this->db->lastInsertId();
    }

    /**
     * affectedRows
     *
     * @return int - affected rows
     */
    public function affectedRows()
    {
        return $this->db->affectedRows();
    }

    /**
     * _startProfile
     *
     * @param string $sql   - sql statement
     * @param array  $bind  - bind variables
     * @param string $notes - profiler notes
     *
     * @return profileId
     */
    private function _startProfile($sql, $bind, $notes)
    {
        //bind variables
        if (is_array($bind) && !empty($bind)) {
            $pattern = '/[?]/';

            foreach ($bind as &$var) {
                switch (gettype($var)) {
                default:
                case 'string':
                    $sql = preg_replace(
                        $pattern,
                        "'" . $this->db->escapeString($var) . "'",
                        $sql,
                        1
                    );
                    break;
                case 'integer':
                    $sql = preg_replace($pattern, $var, $sql, 1);
                    break;
                }
            }
        }

        return $this->profiler->start($this->profileType, $sql, $notes);
    }

    /**
     * _endProfile
     *
     * @param int   $profileId - profile id
     * @param mixed $result    - profile result
     *
     * @return null
     */
    private function _endProfile($profileId, $result)
    {
        return $this->profiler->end($this->profileType, $profileId, $result);
    }
}
