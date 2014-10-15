<?php
/**
 * LinkOfTheWeekModelTest
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
class LinkOfTheWeekModelTest extends BaseModelTest
{
    /**
     * testGetData
     *
     * @return null
     */
    public function testGetData()
    {
        $model = new LinkOfTheWeekModel();
        $model->getData();

        $this->assertArrayHasKey('settings', $model->data);
        $this->assertArrayHasKey('banner', $model->data);
    }

    /**
     * testGetSuggestData
     *
     * @param array $params
     *
     * @dataProvider getSuggestDataProvider
     *
     * @return null
     */
    public function testGetSuggestData($params)
    {
        $model = new LinkOfTheWeekModel();
        $model->getSuggestData($params['params'], $params['isPost']);

        $this->assertArrayHasKey('settings', $model->data);
        $this->assertArrayHasKey('banner', $model->data);
        $this->assertArrayHasKey('redirect', $model->data);
        $this->assertArrayHasKey('link', $model->data);

        $this->assertEquals($params['redirect'], $model->data['redirect']);
        $this->assertEquals($params['errors'], $model->errors);
        $this->assertEquals($params['status'], $model->status);
    }

    /**
     * getSuggestDataProvider
     *
     * @return array
     */
    public function getSuggestDataProvider()
    {
        $tests = array();

        //data set #0 - no data, not a post
        $tests[] = array(
            'params'    => array(),
            'isPost'    => false,
            'redirect'  => false,
            'errors'    => array(),
            'status'    => array(),
        );

        //data set #1 - empty form posted
        $tests[] = array(
            'params'    => array(
                'title'       => '',
                'url'         => '',
                'description' => '',
                'submitter'   => '',
            ),
            'isPost'    => true,
            'redirect'  => false,
            'errors'    => array(
                'Title is required.',
                'URL is required.',
                'Description is required.',
                'Your name is required.',
            ),
            'status'    => array(),
        );

        //data set #2 - invalid url
        $tests[] = array(
            'params'    => array(
                'title'       => 'UNIT TEST TITLE',
                'url'         => 'UNIT TEST URL',
                'description' => 'UNIT TEST DESCRIPTION',
                'submitter'   => 'UNIT TEST',
            ),
            'isPost'    => true,
            'redirect'  => false,
            'errors'    => array(
                'URL not Supported. Only Library of Congress links are allowed.',
            ),
            'status'    => array(),
        );

        //data set #3 - valid input
        $tests[] = array(
            'params'    => array(
                'title'       => 'UNIT TEST TITLE',
                'url'         => 'http://loc.gov/UNIT_TEST_URL',
                'description' => 'UNIT TEST DESCRIPTION',
                'submitter'   => 'UNIT TEST',
            ),
            'isPost'    => true,
            'redirect'  => true,
            'errors'    => array(),
            'status'    => array(
                'Your Link of the Week suggestion has been added and is pending review.'
            ),
        );

        $testParams = array();
        foreach ($tests as $test) {
            $testParams[] = array($test);
        }

        return $testParams;
    }
}
