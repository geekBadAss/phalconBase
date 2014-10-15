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
class PageItem extends BaseDataModel implements DataModel
{
    protected $id;
    protected $pageId;
    protected $itemId;
    protected $ordinal;

    /**
     * getAll
     *
     * @return RS
     */
    public static function getAll()
    {
        $sql = 'select *
                from PageItem';

        return parent::_getAll($sql, array(), __CLASS__);
    }

    /**
     * find
     *
     * @param int $id
     *
     * @return PageItem
     */
    public static function find($id)
    {
        $sql = 'select *
                from PageItem
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
        $sql = 'insert into PageItem
                (pageId, itemId, ordinal)
                values
                (?, ?, ?)';

        $bind = array(
            $this->pageId,
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
        $sql = 'update PageItem
                set pageId = ?,
                    itemId = ?,
                    ordinal = ?
                where id = ?';

        $bind = array(
            $this->pageId,
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
        $sql = 'delete from PageItem
                where id = ?';

        return $this->_delete($sql, array($this->id));
    }
}
