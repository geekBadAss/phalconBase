<?php
/**
 * AuthController
 *
 * @package Controllers
 * @author  aidan lydon <aidanlydon@gmail.com>
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
        $this->model = new UserModel();
        if ($this->request->isPost()) {
            $userCreated = $this->model->createUser($this->getParams());
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
        $this->model = new UserModel();

        if ($this->request->isPost()) {
            $loggedIn = $this->model->login($this->getParams(), $this->request->getClientAddress());
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
        $this->model = new UserModel();
        $this->model->logout();
        //if there is a referer, redirect to it (unless the referrer is a page where the user has to
        //be logged in)
        $this->redirect($this->request->getHttpReferer());
    }
}
