<?php
/**
 * IndexController
 *
 * @package Controllers
 * @author  aidan lydon <aidanlydon@gmail.com>
 */
class IndexController extends BaseController
{
    /**
     * indexAction
     *
     * @return null
     */
    public function indexAction()
    {
        $this->model = new HomePageModel();
        $this->model->getData();
    }
}
