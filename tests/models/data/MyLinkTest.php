<?php
/**
 * MyLinkTest
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
class MyLinkTest extends BaseUnitTest
{
    /**
     * testGetAll
     *
     * @return null
     */
    public function testGetAll()
    {
        $myLinks = MyLink::getAll();
        $this->assertContainsOnly('MyLink', $myLinks);
    }

    /**
     * testFind
     *
     * @return null
     */
    public function testFind()
    {
        $myLink = new MyLink(
            array(
                'username' => 'unit test',
                'itemId'   => 1,
            )
        );
        $id = $myLink->insert();

        $found = MyLink::find($id);
        $this->assertInstanceOf('MyLink', $found);

        $deleted = $myLink->delete();
        $this->assertEquals(1, $deleted);
    }

    /**
     * testInsert
     *
     * @return null
     */
    public function testInsert()
    {
        $myLink = new MyLink(
            array(
                'username' => 'unit test',
                'itemId'   => 1,
            )
        );
        $id = $myLink->insert();
        $this->assertEquals($id, $myLink->id);

        $found = MyLink::find($id);
        $this->assertInstanceOf('MyLink', $found);

        $deleted = $myLink->delete();
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
        $myLink = new MyLink(
            array(
                'username' => 'unit test',
                'itemId'   => 1,
            )
        );
        $id = $myLink->insert();

        //change something
        $newUsername = 'namechange';
        $myLink->username = $newUsername;

        //update
        $updated = $myLink->update();
        $this->assertEquals(1, $updated);

        //find
        $found = MyLink::find($id);
        $this->assertEquals($newUsername, $found->username);

        //clean up
        $deleted = $myLink->delete();
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
        $myLink = new MyLink(
            array(
                'username' => 'unit test',
                'itemId'   => 1,
            )
        );
        $id = $myLink->insert();

        //find
        $found = MyLink::find($id);
        $this->assertInstanceOf('MyLink', $found);

        //delete
        $deleted = $myLink->delete();
        $this->assertEquals(1, $deleted);

        //find again, should be false
        $found = MyLink::find($id);
        $this->assertFalse($found);
    }

    /**
     * testGetAllByUsername
     *
     * @return null
     */
    public function testGetAllByUsername()
    {
        $links = MyLink::getAllByUsername();
        $this->assertNotEmpty('MyLink', $links);
    }
}
