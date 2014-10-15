<?php
/**
 * DoorClosure
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
class DoorClosure extends BaseDataModel implements DataModel
{
    protected $id;
    protected $title;
    protected $description;
    protected $submitted;

    /**
     * getAll
     *
     * @return RS
     */
    public static function getAll()
    {
        $sql = 'select *
                from DoorClosure';

        return parent::_getAll($sql, array(), __CLASS__);
    }

    /**
     * find
     *
     * @param int $id
     *
     * @return DoorClosure
     */
    public static function find($id)
    {
        $sql = 'select *
                from DoorClosure
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
        $sql = 'insert into DoorClosure
                (title, description, submitted)
                values
                (?, ?, ?)';

        $bind = array(
            $this->title,
            $this->description,
            $this->submitted,
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
        $sql = 'update DoorClosure
                set title = ?,
                    description = ?,
                    submitted = ?
                where id = ?';

        $bind = array(
            $this->title,
            $this->description,
            $this->submitted,
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
        $sql = 'delete from DoorClosure
                where id = ?';

        return $this->_delete($sql, array($this->id));
    }

    /**
     * getTodays
     *
     * @return array
     */
    public static function getTodays()
    {
        $sql = 'select *
                from DoorClosure
                where submitted like ?';

        $bind = array(
            date('Y-m-d') . '%',
        );

        return parent::_getAll($sql, $bind, __CLASS__);
    }
}
