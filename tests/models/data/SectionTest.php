<?php
/**
 * SectionTest
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
class SectionTest extends BaseUnitTest
{
    /**
     * testGetAll
     *
     * @return null
     */
    public function testGetAll()
    {
        $sections = Section::getAll();
        $this->assertContainsOnly('Section', $sections);
    }

    /**
     * testFind
     *
     * @return null
     */
    public function testFind()
    {
        $section = new Section(array(
            'title'   => 'test title',
            'ordinal' => 1,
        ));
        $id = $section->insert();

        $found = Section::find($id);
        $this->assertInstanceOf('Section', $found);

        $deleted = $section->delete();
        $this->assertEquals(1, $deleted);
    }

    /**
     * testInsert
     *
     * @return null
     */
    public function testInsert()
    {
        $section = new Section(array(
            'title'   => 'test title',
            'ordinal' => 1,
        ));
        $id = $section->insert();
        $this->assertEquals($id, $section->id);

        $found = Section::find($id);
        $this->assertInstanceOf('Section', $found);

        $deleted = $section->delete();
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
        $section = new Section(array(
            'title'   => 'test title',
            'ordinal' => 1,
        ));
        $id = $section->insert();

        //change something
        $newTitle = 'test title changed';
        $section->title = $newTitle;

        //update
        $updated = $section->update();
        $this->assertEquals(1, $updated);

        //find
        $found = Section::find($id);
        $this->assertEquals($newTitle, $found->title);

        //clean up
        $deleted = $section->delete();
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
        $section = new Section(array(
            'title'   => 'test title',
            'ordinal' => 1,
        ));
        $id = $section->insert();

        //find
        $found = Section::find($id);
        $this->assertInstanceOf('Section', $found);

        //delete
        $deleted = $section->delete();
        $this->assertEquals(1, $deleted);

        //find again, should be false
        $found = Section::find($id);
        $this->assertFalse($found);
    }
}
