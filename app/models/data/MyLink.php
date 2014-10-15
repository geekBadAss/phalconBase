<?php
/**
 * MyLink
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
class MyLink extends BaseDataModel implements DataModel
{
    protected $id;
    protected $username;
    protected $itemId;

    /**
     * getAll
     *
     * @return RS
     */
    public static function getAll()
    {
        $sql = 'select *
                from MyLink';

        return parent::_getAll($sql, array(), __CLASS__);
    }

    /**
     * find
     *
     * @param int $id
     *
     * @return MyLink
     */
    public static function find($id)
    {
        $sql = 'select *
                from MyLink
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
        $sql = 'insert into MyLink
                (username, itemId)
                values
                (?, ?)';

        $bind = array(
            $this->username,
            $this->itemId,
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
        $sql = 'update MyLink
                SET username = ?,
                    itemId = ?
                where id = ?';

        $bind = array(
            $this->username,
            $this->itemId,
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
        $sql = 'delete from MyLink
                where id = ?';

        return $this->_delete($sql, array($this->id));
    }

    /**
     * getAllByUsername
     *
     * @param string $username
     *
     * @return RS
     */
    public static function getAllByUsername($username = 'DFLT')
    {
        $sql = 'select i.title, i.shortTitle, i.url, i.externalLink, i.displayDisclaimer
                from MyLink ml
                left join Item i
                  on ml.itemId = i.id
                where ml.Username = ?
                order by ml.id';

        return parent::_getAll($sql, array($username));
    }
}
