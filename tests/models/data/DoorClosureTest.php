<?php
/**
 * DoorClosureTest
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
class DoorClosureTest extends BaseUnitTest
{
    /**
     * testGetAll
     *
     * @return null
     */
    public function testGetAll()
    {
        $doorClosures = DoorClosure::getAll();
        $this->assertContainsOnly('DoorClosure', $doorClosures);
    }

    /**
     * testFind
     *
     * @return null
     */
    public function testFind()
    {
        $doorClosure = new DoorClosure(
            array(
                'title'       => 'test title',
                'description' => 'test description',
                'submitted'   => date('Y-m-d H:i:s'),
            )
        );
        $id = $doorClosure->insert();

        $found = DoorClosure::find($id);
        $this->assertInstanceOf('DoorClosure', $found);

        $deleted = $doorClosure->delete();
        $this->assertEquals(1, $deleted);
    }

    /**
     * testInsert
     *
     * @return null
     */
    public function testInsert()
    {
        $doorClosure = new DoorClosure(
            array(
                'title'       => 'test title',
                'description' => 'test description',
                'submitted'   => date('Y-m-d H:i:s'),
            )
        );
        $id = $doorClosure->insert();
        $this->assertEquals($id, $doorClosure->id);

        $found = DoorClosure::find($id);
        $this->assertInstanceOf('DoorClosure', $found);

        $deleted = $doorClosure->delete();
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
        $doorClosure = new DoorClosure(
            array(
                'title'       => 'test title',
                'description' => 'test description',
                'submitted'   => date('Y-m-d H:i:s'),
            )
        );
        $id = $doorClosure->insert();

        //change something
        $newDescription = 'test description changed';
        $doorClosure->description = $newDescription;

        //update
        $updated = $doorClosure->update();
        $this->assertEquals(1, $updated);

        //find
        $found = DoorClosure::find($id);
        $this->assertEquals($newDescription, $found->description);

        //clean up
        $deleted = $doorClosure->delete();
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
        $doorClosure = new DoorClosure(
            array(
                'title'       => 'test title',
                'description' => 'test description',
                'submitted'   => date('Y-m-d H:i:s'),
            )
        );
        $id = $doorClosure->insert();

        //find
        $found = DoorClosure::find($id);
        $this->assertInstanceOf('DoorClosure', $found);

        //delete
        $deleted = $doorClosure->delete();
        $this->assertEquals(1, $deleted);

        //find again, should be false
        $found = DoorClosure::find($id);
        $this->assertFalse($found);
    }

    /**
     * testGetTodays
     *
     * @return null
     */
    public function testGetTodays()
    {
        //insert
        $doorClosure = new DoorClosure(
            array(
                'title'       => 'test title',
                'description' => 'test description',
                'submitted'   => date('Y-m-d H:i:s'),
            )
        );
        $id = $doorClosure->insert();

        //get todays
        $todays = DoorClosure::getTodays();
        $this->assertContainsOnly('DoorClosure', $todays);

        //delete
        $deleted = $doorClosure->delete();
        $this->assertEquals(1, $deleted);

        //find, should be false
        $found = DoorClosure::find($id);
        $this->assertFalse($found);
    }
}
