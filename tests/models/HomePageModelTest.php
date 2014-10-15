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

        $this->assertArrayHasKey('settings', $model->data);
        $this->assertArrayHasKey('currentAnnouncement', $model->data);
        $this->assertArrayHasKey('currentNews', $model->data);
        $this->assertArrayHasKey('linkOfTheWeek', $model->data);
        $this->assertArrayHasKey('myLinks', $model->data);
        $this->assertArrayHasKey('sections', $model->data);
    }
}
