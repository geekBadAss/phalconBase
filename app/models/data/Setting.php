<?php
/**
 * Setting
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
class Setting extends BaseDataModel implements DataModel
{
    protected $id;
    protected $name;
    protected $value;
    protected $lastUpdate;

    /**
     * getAll
     *
     * @return RS
     */
    public static function getAll()
    {
        $sql = 'select *
                from Setting';

        return parent::_getAll($sql, array(), __CLASS__);
    }

    /**
     * find
     *
     * @param int $id
     *
     * @return Setting
     */
    public static function find($id)
    {
        $sql = 'select *
                from Setting
                where id = ?';

        return parent::_find($sql, array($id), __CLASS__);
    }

    /**
     * insert
     *
     * @return int
     */
    public function insert()
    {
        $this->lastUpdate = date('Y-m-d H:i:s');

        $sql = 'insert into Setting
                (name, value, lastUpdate)
                values
                (?, ?, ?)';

        $bind = array(
            $this->name,
            $this->value,
            $this->lastUpdate,
        );

        $this->id = $this->_insert($sql, $bind);

        return $this->id;
    }

    /**
     * update
     *
     * @return int
     */
    public function update()
    {
        $this->lastUpdate = date('Y-m-d H:i:s');

        $sql = 'update Setting
                set name = ?,
                    value = ?,
                    lastUpdate = ?
                where id = ?';

        $bind = array(
            $this->name,
            $this->value,
            $this->lastUpdate,
            $this->id,
        );

        return $this->_update($sql, $bind);
    }

    /**
     * delete
     *
     * @return int
     */
    public function delete()
    {
        $sql = 'delete from Setting
                where id = ?';

        return $this->_delete($sql, array($this->id));
    }

    /**
     * getNameValueAssoc
     *
     * @return array
     */
    public static function getNameValueAssoc()
    {
        $sql = 'select name, value
                from Setting';

        return parent::_getAssoc($sql);
    }
}
