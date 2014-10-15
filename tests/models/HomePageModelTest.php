<?php
/**
 * HomePageModelTest
 *
 * PHP Version 5.3
 *
 * @package   Tests
 * @author    aidan lydon <alyo@loc.gov>
 * @copyright 2014 The Library of Congress
 * @license   Copyright 2014 The Library of Congress
 * @version   $Id:$
 * @link      TBD
 * @since     Sept 24, 2014
 */
class HomePageModelTest extends BaseModelTest
{
    /**
     * testGetData
     *
     * @return null
     */
    public function testGetData()
    {
        Memory::delete('HomePageData');

        $model = new HomePageModel();
        $model->getData();

        $this->assertArrayHasKey('settings', $model->data);
        $this->assertArrayHasKey('currentAnnouncement', $model->data);
        $this->assertArrayHasKey('currentNews', $model->data);
        $this->assertArrayHasKey('linkOfTheWeek', $model->data);
        $this->assertArrayHasKey('myLinks', $model->data);
        $this->assertArrayHasKey('sections', $model->data);
    }
}
