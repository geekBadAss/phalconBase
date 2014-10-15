<?php
/**
 * AuthController
 *
 * PHP Version 5.3
 *
 * @package   Controllers
 * @author    aidan lydon <alyo@loc.gov>
 * @copyright 2014 The Library of Congress
 * @license   Copyright 2014 The Library of Congress
 * @version   $Id:$
 * @link      TBD
 * @since     Sept 24, 2014
 */
class AuthController extends BaseController
{
    /**
     * beforeExecuteRoute - ensure there is an authenticated user for all controllers that
     * extend the AuthController, handle the login flow if not
     *
     * @param Phalcon\Mvc\Dispatcher $dispatcher
     *
     * @return null
     */
    public function beforeExecuteRoute($dispatcher)
    {
        parent::beforeExecuteRoute($dispatcher);

        //don't check for an authenticated user for actions in this controller
        if ($this->dispatcher->getControllerName() != 'auth') {
            //check for an authenticated user
            if (!Session::isUserLoggedIn()) {
                //save the requested url in the session for post login redirection
                Session::setRedirectUrl($this->request->getURI());

                //redirect to the login route
                $this->redirectToRoute('login');
            }
        }
    }

    /**
     * createUserAction
     *
     * @return null
     */
    public function createUserAction()
    {
        $this->_model = new UserModel();
        if ($this->request->isPost()) {
            $userCreated = $this->_model->createUser($this->getParams());
            if ($userCreated) {
                //TODO: redirect to where?
                $this->redirect();
            }
        }
    }

    /**
     * loginAction
     *
     * @return null
     */
    public function loginAction()
    {
        $this->_model = new UserModel();

        if ($this->request->isPost()) {
            $loggedIn = $this->_model->login($this->getParams());
            if ($loggedIn) {
                //redirect
                $this->redirect(Session::getRedirectUrl());
            }
        }
    }

    /**
     * logoutAction
     *
     * @return null
     */
    public function logoutAction()
    {
        $this->_model = new UserModel();
        $this->_model->logout();
        //if there is a referer, redirect to it (unless the referrer is a page where the user has to
        //be logged in)
        $this->redirect($this->request->getHttpReferer());
    }
}
