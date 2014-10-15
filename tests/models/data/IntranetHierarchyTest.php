<?php
/**
 * IntranetHierarchyTest
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
class IntranetHierarchyTest extends BaseUnitTest
{
    /**
     * testGetAll
     *
     * @return null
     */
    public function testGetAll()
    {
        $intranetHierarchys = IntranetHierarchy::getAll();
        $this->assertContainsOnly('IntranetHierarchy', $intranetHierarchys);
    }

    /**
     * testFind
     *
     * @return null
     */
    public function testFind()
    {
        $intranetHierarchy = new IntranetHierarchy(
            array(
                'itemId' => 1,
                'one'    => 1,
                'two'    => 2,
                'three'  => 3,
            )
        );
        $id = $intranetHierarchy->insert();

        $found = IntranetHierarchy::find($id);
        $this->assertInstanceOf('IntranetHierarchy', $found);

        $deleted = $intranetHierarchy->delete();
        $this->assertEquals(1, $deleted);
    }

    /**
     * testInsert
     *
     * @return null
     */
    public function testInsert()
    {
        $intranetHierarchy = new IntranetHierarchy(
            array(
                'itemId' => 1,
                'one'    => 1,
                'two'    => 2,
                'three'  => 3,
            )
        );
        $id = $intranetHierarchy->insert();
        $this->assertEquals($id, $intranetHierarchy->id);

        $found = IntranetHierarchy::find($id);
        $this->assertInstanceOf('IntranetHierarchy', $found);

        $deleted = $intranetHierarchy->delete();
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
        $intranetHierarchy = new IntranetHierarchy(
            array(
                'itemId' => 1,
                'one'    => 1,
                'two'    => 2,
                'three'  => 3,
            )
        );
        $id = $intranetHierarchy->insert();

        //change something
        $newOne = 2;
        $intranetHierarchy->one = $newOne;

        //update
        $updated = $intranetHierarchy->update();
        $this->assertEquals(1, $updated);

        //find
        $found = IntranetHierarchy::find($id);
        $this->assertEquals($newOne, $found->one);

        //clean up
        $deleted = $intranetHierarchy->delete();
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
        $intranetHierarchy = new IntranetHierarchy(
            array(
                'itemId' => 1,
                'one'    => 1,
                'two'    => 2,
                'three'  => 3,
            )
        );
        $id = $intranetHierarchy->insert();

        //find
        $found = IntranetHierarchy::find($id);
        $this->assertInstanceOf('IntranetHierarchy', $found);

        //delete
        $deleted = $intranetHierarchy->delete();
        $this->assertEquals(1, $deleted);

        //find again, should be false
        $found = IntranetHierarchy::find($id);
        $this->assertFalse($found);
    }
}
