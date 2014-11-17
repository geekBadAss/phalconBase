<?php
/**
 * HomePageModelTest
 *
 * Tests
 * @author  aidan lydon <aidanlydon@gmail.com>
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

        //$this->assertArrayHasKey('settings', $model->data);
    }
}
