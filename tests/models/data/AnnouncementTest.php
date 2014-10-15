<?php
/**
 * AnnouncementTest
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
class AnnouncementTest extends BaseUnitTest
{
    /**
     * testGetAll
     *
     * @return null
     */
    public function testGetAll()
    {
        $announcements = Announcement::getAll();
        $this->assertContainsOnly('Announcement', $announcements);
    }

    /**
     * testFind
     *
     * @return null
     */
    public function testFind()
    {
        $announcement = new Announcement(
            array(
                'title'       => 'test title',
                'description' => 'test description',
                'lastUpdate'  => date('Y-m-d H:i:s'),
                'dateTime'    => date('Y-m-d H:i:s'),
                'excerpt'     => 'test excerpt',
                'displayed'   => 'N',
            )
        );
        $id = $announcement->insert();

        $found = Announcement::find($id);
        $this->assertInstanceOf('Announcement', $found);

        $deleted = $announcement->delete();
        $this->assertEquals(1, $deleted);
    }

    /**
     * testInsert
     *
     * @return null
     */
    public function testInsert()
    {
        $announcement = new Announcement(
            array(
                'title'       => 'test title',
                'description' => 'test description',
                'lastUpdate'  => date('Y-m-d H:i:s'),
                'dateTime'    => date('Y-m-d H:i:s'),
                'excerpt'     => 'test excerpt',
                'displayed'   => 'N',
            )
        );
        $id = $announcement->insert();
        $this->assertEquals($id, $announcement->id);

        $found = Announcement::find($id);
        $this->assertInstanceOf('Announcement', $found);

        $deleted = $announcement->delete();
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
        $announcement = new Announcement(
            array(
                'title'       => 'test title',
                'description' => 'test description',
                'lastUpdate'  => date('Y-m-d H:i:s'),
                'dateTime'    => date('Y-m-d H:i:s'),
                'excerpt'     => 'test excerpt',
                'displayed'   => 'N',
            )
        );
        $id = $announcement->insert();

        //change something
        $newDescription = 'test description changed';
        $announcement->description = $newDescription;

        //update
        $updated = $announcement->update();
        $this->assertEquals(1, $updated);

        //find
        $found = Announcement::find($id);
        $this->assertEquals($newDescription, $found->description);

        //clean up
        $deleted = $announcement->delete();
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
        $announcement = new Announcement(
            array(
                'title'       => 'test title',
                'description' => 'test description',
                'lastUpdate'  => date('Y-m-d H:i:s'),
                'dateTime'    => date('Y-m-d H:i:s'),
                'excerpt'     => 'test excerpt',
                'displayed'   => 'N',
            )
        );
        $id = $announcement->insert();

        //find
        $found = Announcement::find($id);
        $this->assertInstanceOf('Announcement', $found);

        //delete
        $deleted = $announcement->delete();
        $this->assertEquals(1, $deleted);

        //find again, should be false
        $found = Announcement::find($id);
        $this->assertFalse($found);
    }

    /**
     * testGetLatest
     *
     * @return null
     */
    public function testGetLatest()
    {
        //insert
        $announcement = new Announcement(
            array(
                'title'       => 'test title',
                'description' => 'test description',
                'lastUpdate'  => date('Y-m-d H:i:s'),
                'dateTime'    => date('Y-m-d H:i:s'),
                'excerpt'     => 'test excerpt',
                'displayed'   => 'Y',
            )
        );
        $id = $announcement->insert();

        //get latest
        $found = Announcement::getLatest();
        $this->assertInstanceOf('Announcement', $found);

        //delete
        $deleted = $announcement->delete();
        $this->assertEquals(1, $deleted);

        //find, should be false
        $found = Announcement::find($id);
        $this->assertFalse($found);
    }
}
