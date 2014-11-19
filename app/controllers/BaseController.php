<?php
use Phalcon\Mvc\Controller,
    Phalcon\Mvc\View;

/**
 * BaseController
 *
 * @package Controllers
 * @author  aidan lydon <aidanlydon@gmail.com>
 */
class BaseController extends Controller
{
    protected $model;

    //ordered associative array of url => display (leave url empty for inactive links)
    protected $breadcrumbs;

    /**
     * beforeExecuteRoute
     *
     * @param Phalcon\Mvc\Dispatcher $dispatcher
     *
     * @return null
     */
    public function beforeExecuteRoute($dispatcher)
    {
        //sterilize request params
        $this->dispatcher->setParams(
            $this->_sterilize(
                $this->dispatcher->getParams()
            )
        );

        session_start();

        //TODO: don't log requests in production environments
        //cleanse passwords out of the request parameters
        $params = $this->getParams();
        unset($params['password'], $params['confirmPassword']);

        //log the request
        $log = new RequestLog(
            array(
                'uri'           => $this->request->getURI(),
                'params'        => json_encode($params),
                'dateTime'      => date('Y-m-d H:i:s'),
                'ipAddress'     => $this->request->getClientAddress(),
                'userAgent'     => $this->request->getUserAgent(),
                'module'        => (string)$this->dispatcher->getModuleName(),
                'controller'    => (string)$this->dispatcher->getControllerName(),
                'action'        => (string)$this->dispatcher->getActionName(),
                'userId'        => Session::get('userId'),
                'userSessionId' => Session::get('userSessionId'),
            )
        );
        $log->insert();
    }

    /**
     * afterExecuteRoute
     *
     * @param Phalcon\Mvc\Dispatcher $dispatcher
     *
     * @return null
     */
    public function afterExecuteRoute($dispatcher)
    {
        if (is_subclass_of($this->model, 'BusinessModel')) {
            if ($this->request->isAjax() || $this->request->get('output') == 'json') {

                //disable the view
                $this->disableView();
                header('Content-Type: application/json');
                echo json_encode($this->model->getAllViewData());

            } else {
                $this->view->setVars($this->model->getAllViewData());
                $this->view->breadcrumbs = $this->breadcrumbs;
            }
        }
    }

    /**
     * getParams
     *
     * @return array
     */
    public function getParams()
    {
        return $this->dispatcher->getParams();
    }

    /**
     * getParam
     *
     * @param string $name
     *
     * @return mixed
     */
    public function getParam($name)
    {
        return $this->dispatcher->getParam($name);
    }

    /**
     * getPostParams
     *
     * @return array
     */
    public function getPostParams()
    {
        return $this->request->getPost();
    }

    /**
     * redirect
     *
     * @param string $url
     *
     * @return null
     */
    public function redirect($url = '')
    {
        $this->response->redirect($url);
    }

    /**
     * redirectToRoute
     *
     * @param string $route
     *
     * @return null
     */
    public function redirectToRoute($route)
    {
        $this->response->redirect(array('for' => $route));
    }

    /**
     * disableLayout
     *
     * @return null
     */
    public function disableLayout()
    {
        $this->view->disableLevel(array(
            View::LEVEL_BEFORE_TEMPLATE => true,
            View::LEVEL_LAYOUT          => true,
            View::LEVEL_AFTER_TEMPLATE  => true,
            View::LEVEL_MAIN_LAYOUT     => true,
        ));
    }

    /**
     * disableView
     *
     * @return null
     */
    public function disableView()
    {
        $this->view->disable();
    }

    /**
     * _sterilize
     *
     * @param mixed $input
     *
     * @return mixed
     */
    private function _sterilize($input)
    {
        if (!empty($input)) {
            if (is_array($input)) {
                foreach ($input as $key => &$val) {
                    if (is_array($val)) {
                        //recurse
                        $val = $this->_sterilize($val);
                    } else {
                        $val = $this->_sterilizeSingle($val);
                    }
                }
            } else {
                $input = $this->_sterilizeSingle($input);
            }
        }

        return $input;
    }

    /**
     * _sterilizeSingle
     *
     * @param mixed $input
     *
     * @return mixed
     */
    private function _sterilizeSingle($input)
    {
        $ret = $input;

        if (!is_object($input)) {
            //if this is json...
            $decoded = json_decode($input, true);
            if (!empty($decoded) && $decoded != $input && json_last_error() == JSON_ERROR_NONE) {
                //sterilize the decoded version
                $decoded = $this->_sterilize($decoded);

                //re-encode
                $input = json_encode($decoded);
            }

            $ret = strip_tags($input);
        }

        return $ret;
    }
}
