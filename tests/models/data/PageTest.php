<?php
/**
 * PageTest
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
class PageTest extends BaseUnitTest
{
    /**
     * testGetAll
     *
     * @return null
     */
    public function testGetAll()
    {
        $pages = Page::getAll();
        $this->assertContainsOnly('Page', $pages);
    }

    /**
     * testFind
     *
     * @return null
     */
    public function testFind()
    {
        $page = new Page(
            array(
                'name'         => 'test name',
                'description'  => 'test description',
                'shortName'    => 'test short name',
                'bannerNumber' => 1,
            )
        );
        $id = $page->insert();

        $found = Page::find($id);
        $this->assertInstanceOf('Page', $found);

        $deleted = $page->delete();
        $this->assertEquals(1, $deleted);
    }

    /**
     * testInsert
     *
     * @return null
     */
    public function testInsert()
    {
        $page = new Page(
            array(
                'name'         => 'test name',
                'description'  => 'test description',
                'shortName'    => 'test short name',
                'bannerNumber' => 1,
            )
        );
        $id = $page->insert();
        $this->assertEquals($id, $page->id);

        $found = Page::find($id);
        $this->assertInstanceOf('Page', $found);

        $deleted = $page->delete();
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
        $page = new Page(
            array(
                'name'         => 'test name',
                'description'  => 'test description',
                'shortName'    => 'test short name',
                'bannerNumber' => 1,
            )
        );
        $id = $page->insert();

        //change something
        $newDescription = 'test description changed';
        $page->description = $newDescription;

        //update
        $updated = $page->update();
        $this->assertEquals(1, $updated);

        //find
        $found = Page::find($id);
        $this->assertEquals($newDescription, $found->description);

        //clean up
        $deleted = $page->delete();
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
        $page = new Page(
            array(
                'name'         => 'test name',
                'description'  => 'test description',
                'shortName'    => 'test short name',
                'bannerNumber' => 1,
            )
        );
        $id = $page->insert();

        //find
        $found = Page::find($id);
        $this->assertInstanceOf('Page', $found);

        //delete
        $deleted = $page->delete();
        $this->assertEquals(1, $deleted);

        //find again, should be false
        $found = Page::find($id);
        $this->assertFalse($found);
    }

    /**
     * testFindByShortName
     *
     * @return null
     */
    public function testFindByShortName()
    {
        $shortName = 'clubs';
        $found = Page::findByShortName($shortName);
        $this->assertInstanceOf('Page', $found);
    }
}
