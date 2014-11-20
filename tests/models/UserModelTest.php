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
        $ipAddress = '127.0.0.1';
        $this->model->createUser($params, $ipAddress);
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
        $ipAddress = '127.0.0.1';
        $this->model->login($params, $ipAddress);
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
