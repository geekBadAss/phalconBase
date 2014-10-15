<?php
/**
 * PersonalLink
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
class PersonalLink extends BaseDataModel implements DataModel
{
    protected $id;
    protected $username;
    protected $title;
    protected $url;

    /**
     * getAll
     *
     * @return RS
     */
    public static function getAll()
    {
        $sql = 'select *
                from PersonalLink';

        return parent::_getAll($sql, array(), __CLASS__);
    }

    /**
     * find
     *
     * @param int $id
     *
     * @return PersonalLink
     */
    public static function find($id)
    {
        $sql = 'select *
                from PersonalLink
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
        $sql = 'insert into PersonalLink
                (username, title, url)
                values
                (?, ?, ?)';

        $bind = array(
            $this->username,
            $this->title,
            $this->url,
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
        $sql = 'update PersonalLink
                set username = ?,
                    title = ?,
                    url = ?
                where id = ?';

        $bind = array(
            $this->username,
            $this->title,
            $this->url,
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
        $sql = 'delete from PersonalLink
                where id = ?';

        return $this->_delete($sql, array($this->id));
    }
}
