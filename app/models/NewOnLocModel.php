<?php
/**
 * NewOnLocModel
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
class NewOnLocModel extends IntranetBusinessModel
{
    /**
     * getData
     *
     * @return null
     */
    public function getData()
    {
        $this->data['items'] = array();

        $xml = simplexml_load_file('http://www.loc.gov/rss/pao/web.xml');
        $x = 0;
        foreach ($xml->channel->item as $item) {
    		if ($x < 20) {
    		    $this->data['items'][] = array(
    		        'link'        => $item->link,
    		        'title'       => $item->title,
    		        'description' => $item->description,
		        );
    		}
    		$x++;
    	}
    }
}
