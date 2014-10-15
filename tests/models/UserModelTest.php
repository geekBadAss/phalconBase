<?php
/**
 * UserModelTest
 *
 * Tests
 * @author  aidan lydon <aidanlydon@gmail.com>
 */
class UserModelTest extends BaseModelTest
{
    /**
     * testCreateUser
     *
     * @return null
     */
    public function testCreateUser()
    {
        $params = array();
        $this->model->createUser($params);
    }

    /**
     * testUpdateUser
     *
     * @return null
     */
    public function testUpdateUser()
    {
        $params = array();
        $this->model->updateUser($params);
    }

    /**
     * testDeleteUser
     *
     * @return null
     */
    public function testDeleteUser()
    {
        $params = array();
        $this->model->deleteUser($params);
    }

    /**
     * testLogin
     *
     * @return null
     */
    public function testLogin()
    {
        $params = array();
        $this->model->login($params);
    }

    /**
     * testLogout
     *
     * @return null
     */
    public function testLogout()
    {
        $params = array();
        $this->model->logout($params);
    }
}
