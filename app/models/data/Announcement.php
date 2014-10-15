<?php
/**
 * Announcement
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
class Announcement extends BaseDataModel implements DataModel
{
    protected $id;
    protected $title;
    protected $description;
    protected $lastUpdate;
    protected $dateTime;
    protected $excerpt;
    protected $displayed;

    /**
     * getAll
     *
     * @return RS
     */
    public static function getAll()
    {
        $sql = 'select *
                from Announcement';

        return parent::_getAll($sql, array(), __CLASS__);
    }

    /**
     * find
     *
     * @param int $id
     *
     * @return Announcement
     */
    public static function find($id)
    {
        $sql = 'select *
                from Announcement
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

        $sql = 'insert into Announcement
                (title, description, lastUpdate, dateTime, excerpt, displayed)
                values
                (?, ?, ?, ?, ?, ?)';

        $bind = array(
            $this->title,
            $this->description,
            $this->lastUpdate,
            $this->dateTime,
            $this->excerpt,
            $this->displayed,
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

        $sql = 'update Announcement
                set title = ?,
                    description = ?,
                    lastUpdate = ?,
                    dateTime = ?,
                    excerpt = ?,
                    displayed = ?
                where id = ?';

        $bind = array(
            $this->title,
            $this->description,
            $this->lastUpdate,
            $this->dateTime,
            $this->excerpt,
            $this->displayed,
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
        $sql = 'delete from Announcement
                where id = ?';

        return $this->_delete($sql, array($this->id));
    }

    /**
     * getLatest
     *
     * @return Announcement
     */
    public static function getLatest()
    {
        $sql = 'select *
                from Announcement
                where displayed = "Y"
                order by dateTime desc';

        return parent::_find($sql, array(), __CLASS__);
    }
}
