<?php
/**
 * LinkOfTheWeek
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
class LinkOfTheWeek extends BaseDataModel implements DataModel
{
    protected $id;
    protected $title;
    protected $url;
    protected $description;
    protected $statusLevel;
    protected $submitter;
    protected $submitted;
    protected $startDate;
    protected $endDate;
    protected $displayed;

    /**
     * getAll
     *
     * @return array
     */
    public static function getAll()
    {
        $sql = 'select *
                from LinkOfTheWeek';

        return parent::_getAll($sql, array(), __CLASS__);
    }

    /**
     * find
     *
     * @param int $id
     *
     * @return LinkOfTheWeek
     */
    public static function find($id)
    {
        $sql = 'select *
                from LinkOfTheWeek
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
        $sql = 'insert into LinkOfTheWeek
                (title, url, description, statusLevel, submitter, submitted, startDate, endDate,
                 displayed)
                values
                (?, ?, ?, ?, ?, ?, ?, ?, ?)';

        $bind = array(
            $this->title,
            $this->url,
            $this->description,
            $this->statusLevel,
            $this->submitter,
            $this->submitted,
            $this->startDate,
            $this->endDate,
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
        $sql = 'update LinkOfTheWeek
                set title = ?,
                    url = ?,
                    description = ?,
                    statusLevel = ?,
                    submitter = ?,
                    submitted = ?,
                    startDate = ?,
                    endDate = ?,
                    displayed = ?
                where id = ?';

        $bind = array(
            $this->title,
            $this->url,
            $this->description,
            $this->statusLevel,
            $this->submitter,
            $this->submitted,
            $this->startDate,
            $this->endDate,
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
        $sql = 'delete from LinkOfTheWeek
                where id = ?';

        return $this->_delete($sql, array($this->id));
    }

    /**
     * getLatest
     *
     * @return LinkOfTheWeek
     */
    public static function getLatest()
    {
        $sql = 'select *
                from LinkOfTheWeek
                where statusLevel = "A"
                and displayed = "Y"';

        return parent::_find($sql, array(), __CLASS__);
    }
}
