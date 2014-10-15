<?php
use Phalcon\Mvc\Controller,
    Phalcon\Mvc\View;
/**
 * AnnouncementsController
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
class AnnouncementsController extends BaseController
{
    /**
     * indexAction
     *
     * @return null
     */
    public function indexAction()
    {
        $this->model = new AnnouncementsModel();
        $this->model->getData();
        $this->breadcrumbs = array(
            '' => 'Announcement Archive',
        );
    }

    /**
     * rssAction
     *
     * @return null
     */
    public function rssAction()
    {
        $this->model = new AnnouncementsModel();
        $this->model->getData();

        //disable the layout
        $this->disableLayout();
    }
}
