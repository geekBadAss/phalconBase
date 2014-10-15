<?php
/**
 * PageModelTest
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
class PageModelTest extends BaseModelTest
{
    /**
     * testGetData
     *
     * @return null
     */
    public function testGetData()
    {
        $model = new PageModel();

        $name = 'invalid';
        $model->getData($name);

        $this->assertArrayHasKey('settings', $model->data);
        $this->assertArrayHasKey('page', $model->data);
        $this->assertArrayHasKey('banner', $model->data);
        $this->assertArrayHasKey('head', $model->data);
        $this->assertArrayHasKey('items', $model->data);

        $name = 'clubs';
        $model->getData($name);

        $this->assertArrayHasKey('settings', $model->data);
        $this->assertArrayHasKey('page', $model->data);
        $this->assertArrayHasKey('banner', $model->data);
        $this->assertArrayHasKey('head', $model->data);
        $this->assertArrayHasKey('items', $model->data);
    }
}
