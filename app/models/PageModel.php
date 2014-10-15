<?php
/**
 * PageModel
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
class PageModel extends IntranetBusinessModel
{
    /**
     * getData
     *
     * @param string $name
     *
     * @return null
     */
    public function getData($name)
    {
        if ($page = Page::findByShortName($name)) {
            //short name found
            $this->data['page'] = $page->toArray();
            $this->data['banner'] = BannerImage::find($page->bannerNumber);
            $this->data['head'] = $page->name;

            $items = Item::getAllByPageId($page->id);

            $this->data['items'] = array();
            foreach ($items as $item) {
                $info = $item->toArray();

                if ($info['isPdf'] == 'Y') {
                    $info['pdfInfo'] = '(PDF ' . $info['pdfSize'] . ')';
                } else {
                    $info['pdfInfo'] = '';
                }

                $info['url'] = trim($info['url']);

                if ($info['displayDisclaimer'] == 'Y') {
                    $info['url'] = '/disclaimer?url=' . urlencode($info['url']);
                } elseif (substr($info['url'], 0, 4) != 'http') {
                    $info['url'] = '/' . $info['url'];
                }

                $this->data['items'][] = $info;
            }

        } else {
            //short name not found, show a list of valid pages
            $this->data['page'] = array('name' => 'Intranet Pages');
            $this->data['banner'] = false;
            $this->data['head'] = 'Page Not Found';

            $pages = Page::getAll();

            $this->data['items'] = array();
            foreach ($pages as $page) {
                $this->data['items'][] = array(
                    'url'          => '/page/' . $page->shortName,
                    'title'        => $page->name,
                    'description'  => $page->description,
                    'externalLink' => 'N',
                    'pdfInfo'      => '',
                );
            }
        }
    }
}
