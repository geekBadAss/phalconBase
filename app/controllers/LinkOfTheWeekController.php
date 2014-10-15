<?php
/**
 * LinkOfTheWeekController
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
class LinkOfTheWeekController extends BaseController
{
    /**
     * indexAction
     *
     * @return null
     */
    public function indexAction()
    {
        $this->model = new LinkOfTheWeekModel();
        $this->model->getData();
        $this->breadcrumbs = array(
            '' => 'Link of the Week',
        );
    }

    /**
     * suggestAction
     *
     * @return null
     */
    public function suggestAction()
    {
        $this->model = new LinkOfTheWeekModel();
        $this->model->getSuggestData($this->getPostParams(), $this->request->isPost());
        $this->breadcrumbs = array(
            '/link-of-the-week' => 'Link of the Week',
            ''                  => 'Suggest Link of the Week',
        );

        if ($this->model->data['redirect']) {
            $this->redirect('link-of-the-week/submitted');
        }
    }

    /**
     * submittedAction - confirmation page for the suggestAction
     *
     * @return null
     */
    public function submittedAction()
    {
        $this->model = new LinkOfTheWeekModel();
        $this->model->getSuggestData(array(), false);
        $this->breadcrumbs = array(
            '/link-of-the-week' => 'Link of the Week',
            '' => 'Suggest Link of the Week',
        );
    }
}
