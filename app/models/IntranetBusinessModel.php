<?php
/**
 * IntranetBusinessModel
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
class IntranetBusinessModel extends BusinessModel
{
    /**
     * _init
     *
     * @return null
     */
    protected function _init()
    {
        //get stuff we need on every page (for the layout)
        $this->data['settings'] = Setting::getNameValueAssoc();
    }
}
