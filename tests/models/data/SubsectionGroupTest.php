<?php
/**
 * SubsectionGroupTest
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
class SubsectionGroupTest extends BaseUnitTest
{
    /**
     * testGetAll
     *
     * @return null
     */
    public function testGetAll()
    {
        $subsectionGroups = SubsectionGroup::getAll();
        $this->assertContainsOnly('SubsectionGroup', $subsectionGroups);
    }

    /**
     * testFind
     *
     * @return null
     */
    public function testFind()
    {
        $subsectionGroup = new SubsectionGroup(array(
            'title'        => 'test title',
            'ordinal'      => 1,
            'subsectionId' => 1,
        ));
        $id = $subsectionGroup->insert();

        $found = SubsectionGroup::find($id);
        $this->assertInstanceOf('SubsectionGroup', $found);

        $deleted = $subsectionGroup->delete();
        $this->assertEquals(1, $deleted);
    }

    /**
     * testInsert
     *
     * @return null
     */
    public function testInsert()
    {
        $subsectionGroup = new SubsectionGroup(array(
            'title'        => 'test title',
            'ordinal'      => 1,
            'subsectionId' => 1,
        ));
        $id = $subsectionGroup->insert();
        $this->assertEquals($id, $subsectionGroup->id);

        $found = SubsectionGroup::find($id);
        $this->assertInstanceOf('SubsectionGroup', $found);

        $deleted = $subsectionGroup->delete();
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
        $subsectionGroup = new SubsectionGroup(array(
            'title'        => 'test title',
            'ordinal'      => 1,
            'subsectionId' => 1,
        ));
        $id = $subsectionGroup->insert();

        //change something
        $newTitle = 'test title changed';
        $subsectionGroup->title = $newTitle;

        //update
        $updated = $subsectionGroup->update();
        $this->assertEquals(1, $updated);

        //find
        $found = SubsectionGroup::find($id);
        $this->assertEquals($newTitle, $found->title);

        //clean up
        $deleted = $subsectionGroup->delete();
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
        $subsectionGroup = new SubsectionGroup(array(
            'title'        => 'test title',
            'ordinal'      => 1,
            'subsectionId' => 1,
        ));
        $id = $subsectionGroup->insert();

        //find
        $found = SubsectionGroup::find($id);
        $this->assertInstanceOf('SubsectionGroup', $found);

        //delete
        $deleted = $subsectionGroup->delete();
        $this->assertEquals(1, $deleted);

        //find again, should be false
        $found = SubsectionGroup::find($id);
        $this->assertFalse($found);
    }
}
