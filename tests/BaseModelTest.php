<?php
/**
 * BaseModelTest
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
abstract class BaseModelTest extends BaseUnitTest
{
    protected $model;

    /**
     * setUp
     *
     * @return null
     */
    public function setUp()
    {
        parent::setUp();

        $obj = new ReflectionObject($this);

        $modelClassName = str_replace('Test', '', $obj->getName());

        $this->model = new $modelClassName();
    }

    /**
     * tearDown
     *
     * @return null
     */
    public function tearDown()
    {
        $data = $this->model->getAllViewData();
        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('status', $data);
        $this->assertArrayHasKey('errors', $data);

        $this->model = null;

        parent::tearDown();
    }
}
