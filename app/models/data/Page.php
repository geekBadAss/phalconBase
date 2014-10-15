<?php
/**
 * Page
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
class Page extends BaseDataModel implements DataModel
{
    protected $id;
    protected $name;
    protected $description;
    protected $shortName;
    protected $bannerNumber;

    /**
     * getAll
     *
     * @return RS
     */
    public static function getAll()
    {
        $sql = 'select *
                from Page';

        return parent::_getAll($sql, array(), __CLASS__);
    }

    /**
     * find
     *
     * @param int $id
     *
     * @return Page
     */
    public static function find($id)
    {
        $sql = 'select *
                from Page
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
        $sql = 'insert into Page
                (name, description, shortName, bannerNumber)
                values
                (?, ?, ?, ?)';

        $bind = array(
            $this->name,
            $this->description,
            $this->shortName,
            $this->bannerNumber,
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
        $sql = 'update Page
                set name = ?,
                    description = ?,
                    shortName = ?,
                    bannerNumber = ?
                where id = ?';

        $bind = array(
            $this->name,
            $this->description,
            $this->shortName,
            $this->bannerNumber,
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
        $sql = 'delete from Page
                where id = ?';

        return $this->_delete($sql, array($this->id));
    }

    /**
     * findByShortName
     *
     * @param string $shortName
     *
     * @return Page
     */
    public static function findByShortName($shortName)
    {
        $sql = 'select *
                from Page
                where shortName = ?';

        return parent::_find($sql, array($shortName), __CLASS__);
    }
}
