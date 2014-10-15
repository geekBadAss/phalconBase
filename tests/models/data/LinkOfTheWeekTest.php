<?php
/**
 * LinkOfTheWeekTest
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
class LinkOfTheWeekTest extends BaseUnitTest
{
    /**
     * testGetAll
     *
     * @return null
     */
    public function testGetAll()
    {
        $linkOfTheWeeks = LinkOfTheWeek::getAll();
        $this->assertContainsOnly('LinkOfTheWeek', $linkOfTheWeeks);
    }

    /**
     * testFind
     *
     * @return null
     */
    public function testFind()
    {
        $linkOfTheWeek = new LinkOfTheWeek(
            array(
                'title'       => 'test title',
                'url'         => 'test url',
                'description' => 'test description',
                'statusLevel' => 1,
                'submitter'   => 'unit test',
                'submitted'   => date('Y-m-d H:i:s'),
                'startDate'   => date('Y-m-d'),
                'endDate'     => date('Y-m-d'),
                'displayed'   => 'N',
            )
        );
        $id = $linkOfTheWeek->insert();

        $found = LinkOfTheWeek::find($id);
        $this->assertInstanceOf('LinkOfTheWeek', $found);

        $deleted = $linkOfTheWeek->delete();
        $this->assertEquals(1, $deleted);
    }

    /**
     * testInsert
     *
     * @return null
     */
    public function testInsert()
    {
        $linkOfTheWeek = new LinkOfTheWeek(
            array(
                'title'       => 'test title',
                'url'         => 'test url',
                'description' => 'test description',
                'statusLevel' => 1,
                'submitter'   => 'unit test',
                'submitted'   => date('Y-m-d H:i:s'),
                'startDate'   => date('Y-m-d'),
                'endDate'     => date('Y-m-d'),
                'displayed'   => 'N',
            )
        );
        $id = $linkOfTheWeek->insert();
        $this->assertEquals($id, $linkOfTheWeek->id);

        $found = LinkOfTheWeek::find($id);
        $this->assertInstanceOf('LinkOfTheWeek', $found);

        $deleted = $linkOfTheWeek->delete();
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
        $linkOfTheWeek = new LinkOfTheWeek(
            array(
                'title'       => 'test title',
                'url'         => 'test url',
                'description' => 'test description',
                'statusLevel' => 1,
                'submitter'   => 'unit test',
                'submitted'   => date('Y-m-d H:i:s'),
                'startDate'   => date('Y-m-d'),
                'endDate'     => date('Y-m-d'),
                'displayed'   => 'N',
            )
        );
        $id = $linkOfTheWeek->insert();

        //change something
        $newDescription = 'test description changed';
        $linkOfTheWeek->description = $newDescription;

        //update
        $updated = $linkOfTheWeek->update();
        $this->assertEquals(1, $updated);

        //find
        $found = LinkOfTheWeek::find($id);
        $this->assertEquals($newDescription, $found->description);

        //clean up
        $deleted = $linkOfTheWeek->delete();
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
        $linkOfTheWeek = new LinkOfTheWeek(
            array(
                'title'       => 'test title',
                'url'         => 'test url',
                'description' => 'test description',
                'statusLevel' => 1,
                'submitter'   => 'unit test',
                'submitted'   => date('Y-m-d H:i:s'),
                'startDate'   => date('Y-m-d'),
                'endDate'     => date('Y-m-d'),
                'displayed'   => 'N',
            )
        );
        $id = $linkOfTheWeek->insert();

        //find
        $found = LinkOfTheWeek::find($id);
        $this->assertInstanceOf('LinkOfTheWeek', $found);

        //delete
        $deleted = $linkOfTheWeek->delete();
        $this->assertEquals(1, $deleted);

        //find again, should be false
        $found = LinkOfTheWeek::find($id);
        $this->assertFalse($found);
    }

    /**
     * testGetLatest
     *
     * @return null
     */
    public function testGetLatest()
    {
        $linkOfTheWeek = new LinkOfTheWeek(
            array(
                'title'       => 'test title',
                'url'         => 'test url',
                'description' => 'test description',
                'statusLevel' => 'A',
                'submitter'   => 'unit test',
                'submitted'   => date('Y-m-d H:i:s'),
                'startDate'   => date('Y-m-d'),
                'endDate'     => date('Y-m-d'),
                'displayed'   => 'Y',
            )
        );
        $id = $linkOfTheWeek->insert();

        $latest = LinkOfTheWeek::getLatest();
        $this->assertInstanceOf('LinkOfTheWeek', $latest);

        $deleted = $linkOfTheWeek->delete();
        $this->assertEquals(1, $deleted);
    }
}
