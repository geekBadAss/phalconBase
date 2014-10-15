<?php
/**
 * BannerImageTest
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
class BannerImageTest extends BaseUnitTest
{
    /**
     * testGetAll
     *
     * @return null
     */
    public function testGetAll()
    {
        $images = BannerImage::getAll();
        $this->assertContainsOnly('BannerImage', $images);
    }

    /**
     * testFind
     *
     * @return null
     */
    public function testFind()
    {
        $image = new BannerImage(
            array(
                'name'     => 'test name',
                'altText'  => 'test altText',
                'artist'   => 'test artist',
                'title'    => 'test title',
                'link'     => 'test link',
                'linkText' => 'test linkText',
            )
        );
        $id = $image->insert();

        $found = BannerImage::find($id);
        $this->assertInstanceOf('BannerImage', $found);

        $deleted = $image->delete();
        $this->assertEquals(1, $deleted);
    }

    /**
     * testInsert
     *
     * @return null
     */
    public function testInsert()
    {
        $image = new BannerImage(
            array(
                'name'     => 'test name',
                'altText'  => 'test altText',
                'artist'   => 'test artist',
                'title'    => 'test title',
                'link'     => 'test link',
                'linkText' => 'test linkText',
            )
        );
        $id = $image->insert();
        $this->assertEquals($id, $image->id);

        $found = BannerImage::find($id);
        $this->assertInstanceOf('BannerImage', $found);

        $deleted = $image->delete();
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
        $image = new BannerImage(
            array(
                'name'     => 'test name',
                'altText'  => 'test altText',
                'artist'   => 'test artist',
                'title'    => 'test title',
                'link'     => 'test link',
                'linkText' => 'test linkText',
            )
        );
        $id = $image->insert();

        //change something
        $newName = 'test name changed';
        $image->name = $newName;

        //update
        $updated = $image->update();
        $this->assertEquals(1, $updated);

        //find
        $found = BannerImage::find($id);
        $this->assertEquals($newName, $found->name);

        //clean up
        $deleted = $image->delete();
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
        $image = new BannerImage(
            array(
                'name'     => 'test name',
                'altText'  => 'test altText',
                'artist'   => 'test artist',
                'title'    => 'test title',
                'link'     => 'test link',
                'linkText' => 'test linkText',
            )
        );
        $id = $image->insert();

        //find
        $found = BannerImage::find($id);
        $this->assertInstanceOf('BannerImage', $found);

        //delete
        $deleted = $image->delete();
        $this->assertEquals(1, $deleted);

        //find again, should be false
        $found = BannerImage::find($id);
        $this->assertFalse($found);
    }
}
