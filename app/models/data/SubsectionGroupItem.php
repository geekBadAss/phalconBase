<?php
/**
 * SubsectionGroupItem
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
class SubsectionGroupItem extends BaseDataModel implements DataModel
{
    protected $id;
    protected $subsectionGroupId;
    protected $itemId;
    protected $ordinal;

    /**
     * getAll
     *
     * @return array
     */
    public static function getAll()
    {
        $sql = 'select *
                from SubsectionGroupItem';

        return parent::_getAll($sql, array(), __CLASS__);
    }

    /**
     * find
     *
     * @param int $id
     *
     * @return SubsectionGroupItem
     */
    public static function find($id)
    {
        $sql = 'select *
                from SubsectionGroupItem
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
        $sql = 'insert into SubsectionGroupItem
                (subsectionGroupId, itemId, ordinal)
                values
                (?, ?, ?)';

        $bind = array(
            $this->subsectionGroupId,
            $this->itemId,
            $this->ordinal,
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
        $sql = 'update SubsectionGroupItem
                set subsectionGroupId = ?,
                    itemId = ?,
                    ordinal = ?
                where id = ?';

        $bind = array(
            $this->subsectionGroupId,
            $this->itemId,
            $this->ordinal,
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
        $sql = 'delete from SubsectionGroupItem
                where id = ?';

        return $this->_delete($sql, array($this->id));
    }
}
