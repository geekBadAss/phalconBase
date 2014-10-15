<?php
/**
 * SubsectionTest
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
class SubsectionTest extends BaseUnitTest
{
    /**
     * testGetAll
     *
     * @return null
     */
    public function testGetAll()
    {
        $subsections = Subsection::getAll();
        $this->assertContainsOnly('Subsection', $subsections);
    }

    /**
     * testFind
     *
     * @return null
     */
    public function testFind()
    {
        $subsection = new Subsection(array(
            'title'     => 'test title',
            'ordinal'   => 1,
            'sectionId' => 1,
        ));
        $id = $subsection->insert();

        $found = Subsection::find($id);
        $this->assertInstanceOf('Subsection', $found);

        $deleted = $subsection->delete();
        $this->assertEquals(1, $deleted);
    }

    /**
     * testInsert
     *
     * @return null
     */
    public function testInsert()
    {
        $subsection = new Subsection(array(
            'title'     => 'test title',
            'ordinal'   => 1,
            'sectionId' => 1,
        ));
        $id = $subsection->insert();
        $this->assertEquals($id, $subsection->id);

        $found = Subsection::find($id);
        $this->assertInstanceOf('Subsection', $found);

        $deleted = $subsection->delete();
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
        $subsection = new Subsection(array(
            'title'     => 'test title',
            'ordinal'   => 1,
            'sectionId' => 1,
        ));
        $id = $subsection->insert();

        //change something
        $newTitle = 'test title changed';
        $subsection->title = $newTitle;

        //update
        $updated = $subsection->update();
        $this->assertEquals(1, $updated);

        //find
        $found = Subsection::find($id);
        $this->assertEquals($newTitle, $found->title);

        //clean up
        $deleted = $subsection->delete();
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
        $subsection = new Subsection(array(
            'title'     => 'test title',
            'ordinal'   => 1,
            'sectionId' => 1,
        ));
        $id = $subsection->insert();

        //find
        $found = Subsection::find($id);
        $this->assertInstanceOf('Subsection', $found);

        //delete
        $deleted = $subsection->delete();
        $this->assertEquals(1, $deleted);

        //find again, should be false
        $found = Subsection::find($id);
        $this->assertFalse($found);
    }
}
