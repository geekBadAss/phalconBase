<?php
/**
 * PageController
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
class PageController extends BaseController
{
    /**
     * indexAction
     *
     * @return null
     */
    public function indexAction()
    {
        $this->model = new PageModel();
        $this->model->getData($this->getParam('name'));
        $this->breadcrumbs = array(
            '' => $this->model->data['page']['name'],
        );
    }
}
