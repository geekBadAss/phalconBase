<?php
/**
 * UserModelTest
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
