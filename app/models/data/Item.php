<?php
/**
 * Item
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
class Item extends BaseDataModel implements DataModel
{
    protected $id;
    protected $title;
    protected $shortTitle;
    protected $description;
    protected $url;
    protected $phoneNumber;
    protected $displayHomePage;
    protected $externalLink;
    protected $displayDisclaimer;
    protected $multipleLine;
    protected $isPdf;
    protected $pdfSize;

    /**
     * getAll
     *
     * @return false/array
     */
    public static function getAll()
    {
        $sql = 'select *
                from Item';

        return parent::_getAll($sql, array(), __CLASS__);
    }

    /**
     * find
     *
     * @param int $id
     *
     * @return Item
     */
    public static function find($id)
    {
        $sql = 'select *
                from Item
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
        $sql = 'insert into Item
                (title, shortTitle, description, url, phoneNumber, displayHomePage, externalLink,
                 displayDisclaimer, multipleLine, isPdf, pdfSize)
                values
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

        $bind = array(
            $this->title,
            $this->shortTitle,
            $this->description,
            $this->url,
            $this->phoneNumber,
            $this->displayHomePage,
            $this->externalLink,
            $this->displayDisclaimer,
            $this->multipleLine,
            $this->isPdf,
            $this->pdfSize,
        );

        $this->id = parent::_insert($sql, $bind);

        return $this->id;
    }

    /**
     * update
     *
     * @return int
     */
    public function update()
    {
        $sql = 'update Item
                set title = ?,
                    shortTitle = ?,
                    description = ?,
                    url = ?,
                    phoneNumber = ?,
                    displayHomePage = ?,
                    externalLink = ?,
                    displayDisclaimer = ?,
                    multipleLine = ?,
                    isPdf = ?,
                    pdfSize = ?
                where id = ?';

        $bind = array(
            $this->title,
            $this->shortTitle,
            $this->description,
            $this->url,
            $this->phoneNumber,
            $this->displayHomePage,
            $this->externalLink,
            $this->displayDisclaimer,
            $this->multipleLine,
            $this->isPdf,
            $this->pdfSize,
            $this->id,
        );

        return parent::_update($sql, $bind);
    }

    /**
     * delete
     *
     * @return int
     */
    public function delete()
    {
        $sql = 'delete from Item
                where id = ?';

        return $this->_delete($sql, array($this->id));
    }

    /**
     * getAllByPageId
     *
     * @param int $pageId
     *
     * @return array
     */
    public static function getAllByPageId($pageId)
    {
        $sql = 'select i.*
                from Item i
                join PageItem pi
                  on i.id = pi.itemId
                where pi.pageId = ?
                order by pi.ordinal asc, i.title asc';

        return parent::_getAll($sql, array($pageId), __CLASS__);
    }

    /**
     * getHomePageItems
     *
     * @return array
     */
    public static function getHomePageItems()
    {
        //this is an example of getting a resultset and returning an array rather than an array of
        //objects (by not sending null for the 3rd param to parent::_getAll)
        $sql = 'select
                  s.id as `sectionId`,
                  s.title as `sectionTitle`,
                  ss.id as `subsectionId`,
                  ss.title as `subsectionTitle`,
                  ssg.id as `subsectionGroupId`,
                  ssg.title as `subsectionGroupTitle`,
                  i.*
                from Section s
                join Subsection ss
                  on s.id = ss.sectionId
                join SubsectionGroup ssg
                  on ss.id = ssg.subsectionId
                join SubsectionGroupItem ssgi
                  on ssg.id = ssgi.subsectionGroupId
                join Item i
                  on ssgi.itemId = i.id
                where i.displayHomePage = "Y"
                order by
                  s.ordinal asc,
                  ss.ordinal asc,
                  ssg.ordinal asc,
                  ssgi.ordinal asc';

        return parent::_getAll($sql);
    }
}
