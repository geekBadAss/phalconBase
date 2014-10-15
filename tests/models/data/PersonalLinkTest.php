<?php
/**
 * PersonalLinkTest
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
class PersonalLinkTest extends BaseUnitTest
{
    /**
     * testGetAll
     *
     * @return null
     */
    public function testGetAll()
    {
        $personalLinks = PersonalLink::getAll();
        $this->assertContainsOnly('PersonalLink', $personalLinks);
    }

    /**
     * testFind
     *
     * @return null
     */
    public function testFind()
    {
        $personalLink = new PersonalLink(
            array(
                'username' => 'test name',
                'title'    => 'test title',
                'url'      => 'test url',
            )
        );
        $id = $personalLink->insert();

        $found = PersonalLink::find($id);
        $this->assertInstanceOf('PersonalLink', $found);

        $deleted = $personalLink->delete();
        $this->assertEquals(1, $deleted);
    }

    /**
     * testInsert
     *
     * @return null
     */
    public function testInsert()
    {
        $personalLink = new PersonalLink(
            array(
                'username' => 'test name',
                'title'    => 'test title',
                'url'      => 'test url',
            )
        );
        $id = $personalLink->insert();
        $this->assertEquals($id, $personalLink->id);

        $found = PersonalLink::find($id);
        $this->assertInstanceOf('PersonalLink', $found);

        $deleted = $personalLink->delete();
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
        $personalLink = new PersonalLink(
            array(
                'username' => 'test name',
                'title'    => 'test title',
                'url'      => 'test url',
            )
        );
        $id = $personalLink->insert();

        //change something
        $newTitle = 'test title changed';
        $personalLink->title = $newTitle;

        //update
        $updated = $personalLink->update();
        $this->assertEquals(1, $updated);

        //find
        $found = PersonalLink::find($id);
        $this->assertEquals($newTitle, $found->title);

        //clean up
        $deleted = $personalLink->delete();
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
        $personalLink = new PersonalLink(
            array(
                'username' => 'test name',
                'title'    => 'test title',
                'url'      => 'test url',
            )
        );
        $id = $personalLink->insert();

        //find
        $found = PersonalLink::find($id);
        $this->assertInstanceOf('PersonalLink', $found);

        //delete
        $deleted = $personalLink->delete();
        $this->assertEquals(1, $deleted);

        //find again, should be false
        $found = PersonalLink::find($id);
        $this->assertFalse($found);
    }
}
