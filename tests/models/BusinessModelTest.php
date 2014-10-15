<?php
/**
 * BusinessModelTest
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
class BusinessModelTest extends BaseModelTest
{
    /**
     * testGetAllViewData
     *
     * @return null
     */
    public function testGetAllViewData()
    {
        $model = new BusinessModel();
        $viewData = $model->getAllViewData();

        $this->assertArrayHasKey('data', $viewData);
        $this->assertArrayHasKey('status', $viewData);
        $this->assertArrayHasKey('errors', $viewData);
    }

    /**
     * testAddError
     *
     * @return null
     */
    public function testAddError()
    {
        $model = new BusinessModel();

        $errorMessage = 'there was an error';
        $model->addError($errorMessage);

        $viewData = $model->getAllViewData();
        $this->assertEquals(array($errorMessage), $viewData['errors']);
    }

    /**
     * testNoErrors
     *
     * @return null
     */
    public function testNoErrors()
    {
        $model = new BusinessModel();
        $this->assertTrue($model->noErrors());

        $errorMessage = 'there was an error';
        $model->addError($errorMessage);

        $this->assertFalse($model->noErrors());
    }

    /**
     * testAddStatus
     *
     * @return null
     */
    public function testAddStatus()
    {
        $model = new BusinessModel();

        $statusMessage = 'there was a change that warrants a status message';
        $model->addStatus($statusMessage);

        $viewData = $model->getAllViewData();
        $this->assertEquals(array($statusMessage), $viewData['status']);
    }
}
