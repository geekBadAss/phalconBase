<?php
/**
 * NewsTest
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
class NewsTest extends BaseUnitTest
{
    /**
     * testGetAll
     *
     * @return null
     */
    public function testGetAll()
    {
        $newses = News::getAll();
        $this->assertContainsOnly('News', $newses);
    }

    /**
     * testFind
     *
     * @return null
     */
    public function testFind()
    {
        $news = new News(
            array(
                'title'       => 'test title',
                'description' => 'test description',
                'lastUpdate'  => date('Y-m-d H:i:s'),
                'excerpt'     => 'test excerpt',
                'displayed'   => 'N',
                'dateTime'    => date('Y-m-d H:i:s'),
            )
        );
        $id = $news->insert();

        $found = News::find($id);
        $this->assertInstanceOf('News', $found);

        $deleted = $news->delete();
        $this->assertEquals(1, $deleted);
    }

    /**
     * testInsert
     *
     * @return null
     */
    public function testInsert()
    {
        $news = new News(
            array(
                'title'       => 'test title',
                'description' => 'test description',
                'lastUpdate'  => date('Y-m-d H:i:s'),
                'excerpt'     => 'test excerpt',
                'displayed'   => 'N',
                'dateTime'    => date('Y-m-d H:i:s'),
            )
        );
        $id = $news->insert();
        $this->assertEquals($id, $news->id);

        $found = News::find($id);
        $this->assertInstanceOf('News', $found);

        $deleted = $news->delete();
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
        $news = new News(
            array(
                'title'       => 'test title',
                'description' => 'test description',
                'lastUpdate'  => date('Y-m-d H:i:s'),
                'excerpt'     => 'test excerpt',
                'displayed'   => 'N',
                'dateTime'    => date('Y-m-d H:i:s'),
            )
        );
        $id = $news->insert();

        //change something
        $newDescription = 'test description changed';
        $news->description = $newDescription;

        //update
        $updated = $news->update();
        $this->assertEquals(1, $updated);

        //find
        $found = News::find($id);
        $this->assertEquals($newDescription, $found->description);

        //clean up
        $deleted = $news->delete();
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
        $news = new News(
            array(
                'title'       => 'test title',
                'description' => 'test description',
                'lastUpdate'  => date('Y-m-d H:i:s'),
                'excerpt'     => 'test excerpt',
                'displayed'   => 'N',
                'dateTime'    => date('Y-m-d H:i:s'),
            )
        );
        $id = $news->insert();

        //find
        $found = News::find($id);
        $this->assertInstanceOf('News', $found);

        //delete
        $deleted = $news->delete();
        $this->assertEquals(1, $deleted);

        //find again, should be false
        $found = News::find($id);
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
        $news = new News(
            array(
                'title'       => 'test title',
                'description' => 'test description',
                'lastUpdate'  => date('Y-m-d H:i:s'),
                'excerpt'     => 'test excerpt',
                'displayed'   => 'Y',
                'dateTime'    => date('Y-m-d H:i:s'),
            )
        );
        $id = $news->insert();

        //getLatest
        $latest = News::getLatest();
        $this->assertInstanceOf('News', $latest);

        //delete
        $deleted = $news->delete();
        $this->assertEquals(1, $deleted);
    }
}
