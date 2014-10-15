<?php
/**
 * SubsectionGroup
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
class SubsectionGroup extends BaseDataModel implements DataModel
{
    protected $id;
    protected $title;
    protected $subsectionId;
    protected $ordinal;

    /**
     * getAll
     *
     * @return array
     */
    public static function getAll()
    {
        $sql = 'select *
                from SubsectionGroup';

        return parent::_getAll($sql, array(), __CLASS__);
    }

    /**
     * find
     *
     * @param int $id
     *
     * @return SubsectionGroup
     */
    public static function find($id)
    {
        $sql = 'select *
                from SubsectionGroup
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
        $sql = 'insert into SubsectionGroup
                (title, subsectionId, ordinal)
                values
                (?, ?, ?)';

        $bind = array(
            $this->title,
            $this->subsectionId,
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
        $sql = 'update SubsectionGroup
                set title = ?,
                    subsectionId = ?,
                    ordinal = ?
                where id = ?';

        $bind = array(
            $this->title,
            $this->subsectionId,
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
        $sql = 'delete from SubsectionGroup
                where id = ?';

        return $this->_delete($sql, array($this->id));
    }
}
