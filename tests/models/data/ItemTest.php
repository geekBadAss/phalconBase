<?php
/**
 * ItemTest
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
class ItemTest extends BaseUnitTest
{
    /**
     * testGetAll
     *
     * @return null
     */
    public function testGetAll()
    {
        $items = Item::getAll();
        $this->assertContainsOnly('Item', $items);
    }

    /**
     * testFind
     *
     * @return null
     */
    public function testFind()
    {
        $item = new Item(
            array(
                'title'             => 'test title',
                'shortTitle'        => 'test short title',
                'description'       => 'test description',
                'url'               => 'test url',
                'phoneNumber'       => '7-0478',
                'displayHomePage'   => 'N',
                'externalLink'      => 'N',
                'displayDisclaimer' => 'N',
                'multipleLine'      => 'N',
                'isPdf'             => 'N',
                'pdfSize'           => 0,
            )
        );
        $id = $item->insert();

        $found = Item::find($id);
        $this->assertInstanceOf('Item', $found);

        $deleted = $item->delete();
        $this->assertEquals(1, $deleted);
    }

    /**
     * testInsert
     *
     * @return null
     */
    public function testInsert()
    {
        $item = new Item(
            array(
                'title'             => 'test title',
                'shortTitle'        => 'test short title',
                'description'       => 'test description',
                'url'               => 'test url',
                'phoneNumber'       => '7-0478',
                'displayHomePage'   => 'N',
                'externalLink'      => 'N',
                'displayDisclaimer' => 'N',
                'multipleLine'      => 'N',
                'isPdf'             => 'N',
                'pdfSize'           => 0,
            )
        );
        $id = $item->insert();
        $this->assertEquals($id, $item->id);

        $found = Item::find($id);
        $this->assertInstanceOf('Item', $found);

        $deleted = $item->delete();
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
        $item = new Item(
            array(
                'title'             => 'test title',
                'shortTitle'        => 'test short title',
                'description'       => 'test description',
                'url'               => 'test url',
                'phoneNumber'       => '7-0478',
                'displayHomePage'   => 'N',
                'externalLink'      => 'N',
                'displayDisclaimer' => 'N',
                'multipleLine'      => 'N',
                'isPdf'             => 'N',
                'pdfSize'           => 0,
            )
        );
        $id = $item->insert();

        //change something
        $newDescription = 'test description changed';
        $item->description = $newDescription;

        //update
        $updated = $item->update();
        $this->assertEquals(1, $updated);

        //find
        $found = Item::find($id);
        $this->assertEquals($newDescription, $found->description);

        //clean up
        $deleted = $item->delete();
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
        $item = new Item(
            array(
                'title'             => 'test title',
                'shortTitle'        => 'test short title',
                'description'       => 'test description',
                'url'               => 'test url',
                'phoneNumber'       => '7-0478',
                'displayHomePage'   => 'N',
                'externalLink'      => 'N',
                'displayDisclaimer' => 'N',
                'multipleLine'      => 'N',
                'isPdf'             => 'N',
                'pdfSize'           => 0,
            )
        );
        $id = $item->insert();

        //find
        $found = Item::find($id);
        $this->assertInstanceOf('Item', $found);

        //delete
        $deleted = $item->delete();
        $this->assertEquals(1, $deleted);

        //find again, should be false
        $found = Item::find($id);
        $this->assertFalse($found);
    }

    /**
     * testGetAllByPageId
     *
     * @return null
     */
    public function testGetAllByPageId()
    {
        $items = Item::getAllByPageId(1);
        $this->assertContainsOnly('Item', $items);
    }

    /**
     * testGetHomePageItems
     *
     * @return null
     */
    public function testGetHomePageItems()
    {
        $items = Item::getHomePageItems();
        $this->assertNotEmpty($items);
    }
}
