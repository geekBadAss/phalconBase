<?php
/**
 * BaseModelTest
 *
 * Tests
 * @author  aidan lydon <aidanlydon@gmail.com>
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
