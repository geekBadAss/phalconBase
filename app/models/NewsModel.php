<?php
/**
 * NewsModel
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
class NewsModel extends IntranetBusinessModel
{
    /**
     * getData
     *
     * @return null
     */
    public function getData()
    {
        $this->data['banner'] = BannerImage::find(2);
    }
}