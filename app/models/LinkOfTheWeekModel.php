<?php
/**
 * LinkOfTheWeekModel
 *
 * PHP Version 5.3
 *
 * @package   BusinessModels
 * @author    aidan lydon <alyo@loc.gov>
 * @copyright 2014 The Library of Congress
 * @license   Copyright 2014 The Library of Congress
 * @version   $Id:$
 * @link      TBD
 * @since     Sept 24, 2014
 */
class LinkOfTheWeekModel extends IntranetBusinessModel
{
    /**
     * getData
     *
     * @return null
     */
    public function getData()
    {
        $this->data['banner'] = BannerImage::find(3);
    }

    /**
     * getSubmitData
     *
     * @param array $params - posted parameters
     * @param bool  $isPost - whether the request is a post
     *
     * @return null
     */
    public function getSuggestData($params, $isPost)
    {
        try {
            $this->data['redirect'] = false;

            $this->data['banner'] = BannerImage::find(4);

            //default
            $this->data['link'] = new LinkOfTheWeek();

            if ($isPost) {
                $this->data['link']->title       = $params['title'];
                $this->data['link']->url         = $params['url'];
                $this->data['link']->description = $params['description'];
                $this->data['link']->submitter   = $params['submitter'];

                //validate
                if (empty($params['title'])) {
                    $this->addError('Title is required.');
                }

                if (empty($params['url'])) {
                    $this->addError('URL is required.');
                } else {
                    $validUrls = array(
                        'loc.gov',
                        'myloc.gov',
                        'digitizationguidelines.gov',
                        'digitalpreservation.gov',
                        'americaslibrary.gov',
                        'copyright.gov',
                    );

                    $urlValid = false;

                    foreach ($validUrls as $url) {
                        if (stristr($params['url'], $url)) {
                            $urlValid = true;
                            break;
                        }
                    }

                    if (!$urlValid) {
                        $this->addError(
                            'URL not Supported. Only Library of Congress links are allowed.'
                        );
                    }
                }

                if (empty($params['description'])) {
                    $this->addError('Description is required.');
                }

                if (empty($params['submitter'])) {
                    $this->addError('Your name is required.');
                }

                if ($this->noErrors()) {
                    //input is valid... set a few other default values
                    $this->data['link']->statusLevel = 'P';
                    $this->data['link']->submitted   = date('Y-m-d H:i:s');
                    $this->data['link']->startDate   = date('Y-m-d');
                    $this->data['link']->endDate     = date('Y-m-d');
                    $this->data['link']->displayed   = 'N';

                    //insert
                    $this->data['link']->insert();

                    $this->addStatus(
                        'Your Link of the Week suggestion has been added and is pending review.'
                    );

                    $this->data['redirect'] = true;
                }
            }

        } catch (Exception $e) {
            //@codeCoverageIgnoreStart
            xlog($e);
            //@codeCoverageIgnoreEnd
        }
    }
}
