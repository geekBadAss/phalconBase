<?php
/**
 * SubsectionGroupItemTest
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
class SubsectionGroupItemTest extends BaseUnitTest
{
    /**
     * testGetAll
     *
     * @return null
     */
    public function testGetAll()
    {
        $subsectionGroupItems = SubsectionGroupItem::getAll();
        $this->assertContainsOnly('SubsectionGroupItem', $subsectionGroupItems);
    }

    /**
     * testFind
     *
     * @return null
     */
    public function testFind()
    {
        $subsectionGroupItem = new SubsectionGroupItem(array(
            'subsectionGroupId' => 1,
            'itemId'            => 1,
            'ordinal'           => 1,
        ));
        $id = $subsectionGroupItem->insert();

        $found = SubsectionGroupItem::find($id);
        $this->assertInstanceOf('SubsectionGroupItem', $found);

        $deleted = $subsectionGroupItem->delete();
        $this->assertEquals(1, $deleted);
    }

    /**
     * testInsert
     *
     * @return null
     */
    public function testInsert()
    {
        $subsectionGroupItem = new SubsectionGroupItem(array(
            'subsectionGroupId' => 1,
            'itemId'            => 1,
            'ordinal'           => 1,
        ));
        $id = $subsectionGroupItem->insert();
        $this->assertEquals($id, $subsectionGroupItem->id);

        $found = SubsectionGroupItem::find($id);
        $this->assertInstanceOf('SubsectionGroupItem', $found);

        $deleted = $subsectionGroupItem->delete();
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
        $subsectionGroupItem = new SubsectionGroupItem(array(
            'subsectionGroupId' => 1,
            'itemId'            => 1,
            'ordinal'           => 1,
        ));
        $id = $subsectionGroupItem->insert();

        //change something
        $newSubsectionGroupId = 2;
        $subsectionGroupItem->subsectionGroupId = $newSubsectionGroupId;

        //update
        $updated = $subsectionGroupItem->update();
        $this->assertEquals(1, $updated);

        //find
        $found = SubsectionGroupItem::find($id);
        $this->assertEquals($newSubsectionGroupId, $found->subsectionGroupId);

        //clean up
        $deleted = $subsectionGroupItem->delete();
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
        $subsectionGroupItem = new SubsectionGroupItem(array(
            'subsectionGroupId' => 1,
            'itemId'            => 1,
            'ordinal'           => 1,
        ));
        $id = $subsectionGroupItem->insert();

        //find
        $found = SubsectionGroupItem::find($id);
        $this->assertInstanceOf('SubsectionGroupItem', $found);

        //delete
        $deleted = $subsectionGroupItem->delete();
        $this->assertEquals(1, $deleted);

        //find again, should be false
        $found = SubsectionGroupItem::find($id);
        $this->assertFalse($found);
    }
}
