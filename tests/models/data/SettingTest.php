<?php
/**
 * SettingTest
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
class SettingTest extends BaseUnitTest
{
    /**
     * testGetAll
     *
     * @return null
     */
    public function testGetAll()
    {
        $settings = Setting::getAll();
        $this->assertContainsOnly('Setting', $settings);
    }

    /**
     * testFind
     *
     * @return null
     */
    public function testFind()
    {
        $setting = new Setting(
            array(
                'name'       => 'test name',
                'value'      => 'test value',
                'lastUpdate' => date('Y-m-d H:i:s'),
            )
        );
        $id = $setting->insert();

        $found = Setting::find($id);
        $this->assertInstanceOf('Setting', $found);

        $deleted = $setting->delete();
        $this->assertEquals(1, $deleted);
    }

    /**
     * testInsert
     *
     * @return null
     */
    public function testInsert()
    {
        $setting = new Setting(
            array(
                'name'       => 'test name',
                'value'      => 'test value',
                'lastUpdate' => date('Y-m-d H:i:s'),
            )
        );
        $id = $setting->insert();
        $this->assertEquals($id, $setting->id);

        $found = Setting::find($id);
        $this->assertInstanceOf('Setting', $found);

        $deleted = $setting->delete();
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
        $setting = new Setting(
            array(
                'name'       => 'test name',
                'value'      => 'test value',
                'lastUpdate' => date('Y-m-d H:i:s'),
            )
        );
        $id = $setting->insert();

        //change something
        $newValue = 'test value changed';
        $setting->value = $newValue;

        //update
        $updated = $setting->update();
        $this->assertEquals(1, $updated);

        //find
        $found = Setting::find($id);
        $this->assertEquals($newValue, $found->value);

        //clean up
        $deleted = $setting->delete();
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
        $setting = new Setting(
            array(
                'name'       => 'test name',
                'value'      => 'test value',
                'lastUpdate' => date('Y-m-d H:i:s'),
            )
        );
        $id = $setting->insert();

        //find
        $found = Setting::find($id);
        $this->assertInstanceOf('Setting', $found);

        //delete
        $deleted = $setting->delete();
        $this->assertEquals(1, $deleted);

        //find again, should be false
        $found = Setting::find($id);
        $this->assertFalse($found);
    }

    /**
     * testGetNameValueAssoc
     *
     * @return null
     */
    public function testGetNameValueAssoc()
    {
        $settings = Setting::getNameValueAssoc();
        $this->assertNotEmpty($settings);
    }
}
