<?php
/**
 * NewsController
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
class NewsController extends BaseController
{
    /**
     * indexAction
     *
     * @return null
     */
    public function indexAction()
    {
        $this->model = new NewsModel();
        $this->model->getData();
        $this->breadcrumbs = array(
            '' => 'News Archive',
        );
    }

    /**
     * rssAction
     *
     * @return null
     */
    public function rssAction()
    {
        $this->model = new NewsModel();
        $this->model->getData();

        //TODO: disable the layout

        //TODO: send content-type xml header


    }
}
