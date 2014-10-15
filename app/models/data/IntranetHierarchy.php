<?php
/**
 * IntranetHierarchy
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
class IntranetHierarchy extends BaseDataModel implements DataModel
{
    protected $id;
    protected $itemId;
    protected $one;
    protected $two;
    protected $three;

    /**
     * getAll
     *
     * @return RS
     */
    public static function getAll()
    {
        $sql = 'select *
                from IntranetHierarchy';

        return parent::_getAll($sql, array(), __CLASS__);
    }

    /**
     * find
     *
     * @param int $id
     *
     * @return IntranetHierarchy
     */
    public static function find($id)
    {
        $sql = 'select *
                from IntranetHierarchy
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
        $sql = 'insert into IntranetHierarchy
                (itemId, one, two, three)
                values
                (?, ?, ?, ?)';

        $bind = array(
            $this->itemId,
            $this->one,
            $this->two,
            $this->three,
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
        $sql = 'update IntranetHierarchy
                set itemId = ?,
                    one = ?,
                    two = ?,
                    three = ?
                where id = ?';

        $bind = array(
            $this->itemId,
            $this->one,
            $this->two,
            $this->three,
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
        $sql = 'delete from IntranetHierarchy
                where id = ?';

        return $this->_delete($sql, array($this->id));
    }
}
