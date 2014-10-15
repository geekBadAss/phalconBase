<?php
/**
 * BannerImage
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
class BannerImage extends BaseDataModel implements DataModel
{
    protected $id;
    protected $name;
    protected $altText;
    protected $artist;
    protected $title;
    protected $link;
    protected $linkText;

    /**
     * getAll
     *
     * @return RS
     */
    public static function getAll()
    {
        $sql = 'select *
                from BannerImage';

        return parent::_getAll($sql, array(), __CLASS__);
    }

    /**
     * find
     *
     * @param int $id
     *
     * @return BannerImage
     */
    public static function find($id)
    {
        $sql = 'select *
                from BannerImage
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
        $sql = 'insert into BannerImage
                (name, altText, artist, title, link, linkText)
                VALUES
                (?, ?, ?, ?, ?, ?)';

        $bind = array(
            $this->name,
            $this->altText,
            $this->artist,
            $this->title,
            $this->link,
            $this->linkText,
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
        $sql = 'update BannerImage
                set name = ?,
                    altText = ?,
                    artist = ?,
                    title = ?,
                    link = ?,
                    linkText = ?
                where id = ?';

        $bind = array(
            $this->name,
            $this->altText,
            $this->artist,
            $this->title,
            $this->link,
            $this->linkText,
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
        $sql = 'delete from BannerImage
                where id = ?';

        return $this->_delete($sql, array($this->id));
    }
}
