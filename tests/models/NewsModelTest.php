<?php
/**
 * NewsModelTest
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
class NewsModelTest extends BaseModelTest
{
    /**
     * testGetData
     *
     * @return null
     */
    public function testGetData()
    {
        $model = new NewsModel();
        $model->getData();

        $this->assertArrayHasKey('settings', $model->data);
        $this->assertArrayHasKey('banner', $model->data);
    }
}
