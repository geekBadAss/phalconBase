<?php
/**
 * PageItemTest
 *
 * PHP Version 5.3
 *
 * @package   DataModelTests
 * @author    aidan lydon <alyo@loc.gov>
 * @copyright 2014 The Library of Congress
 * @license   Copyright 2014 The Library of Congress
 * @version   $Id:$
 * @link      TBD
 * @since     Sept 24, 2014
 */
class PageItemTest extends BaseUnitTest
{
    /**
     * testGetAll
     *
     * @return null
     */
    public function testGetAll()
    {
        $pageItems = PageItem::getAll();
        $this->assertContainsOnly('PageItem', $pageItems);
    }

    /**
     * testFind
     *
     * @return null
     */
    public function testFind()
    {
        $pageItem = new PageItem(
            array(
                'pageId'  => 1,
                'itemId'  => 1,
                'ordinal' => 1,
            )
        );
        $id = $pageItem->insert();

        $found = PageItem::find($id);
        $this->assertInstanceOf('PageItem', $found);

        $deleted = $pageItem->delete();
        $this->assertEquals(1, $deleted);
    }

    /**
     * testInsert
     *
     * @return null
     */
    public function testInsert()
    {
        $pageItem = new PageItem(
            array(
                'pageId'  => 1,
                'itemId'  => 1,
                'ordinal' => 1,
            )
        );
        $id = $pageItem->insert();
        $this->assertEquals($id, $pageItem->id);

        $found = PageItem::find($id);
        $this->assertInstanceOf('PageItem', $found);

        $deleted = $pageItem->delete();
        $this->assertEquals(1, $deleted);
    }

    /**
     * testUpdate
     *
     * @return null
     */
    public function testUpdate()
    {
        //insert
        $pageItem = new PageItem(
            array(
                'pageId'  => 1,
                'itemId'  => 1,
                'ordinal' => 1,
            )
        );
        $id = $pageItem->insert();

        //change something
        $newOrdinal = 2;
        $pageItem->ordinal = $newOrdinal;

        //update
        $updated = $pageItem->update();
        $this->assertEquals(1, $updated);

        //find
        $found = PageItem::find($id);
        $this->assertEquals($newOrdinal, $found->ordinal);

        //clean up
        $deleted = $pageItem->delete();
        $this->assertEquals(1, $deleted);
    }

    /**
     * testDelete
     *
     * @return null
     */
    public function testDelete()
    {
        //insert
        $pageItem = new PageItem(
            array(
                'pageId'  => 1,
                'itemId'  => 1,
                'ordinal' => 1,
            )
        );
        $id = $pageItem->insert();

        //find
        $found = PageItem::find($id);
        $this->assertInstanceOf('PageItem', $found);

        //delete
        $deleted = $pageItem->delete();
        $this->assertEquals(1, $deleted);

        //find again, should be false
        $found = PageItem::find($id);
        $this->assertFalse($found);
    }
}
