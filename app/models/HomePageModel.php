<?php
/**
 * HomePageModel
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
class HomePageModel extends IntranetBusinessModel
{
    /**
     * getData
     *
     * @return null
     */
    public function getData()
    {
        //TODO: keys should be generated using a constant somewhere
        $key = 'HomePageData';

        if (!$data = Memory::get($key)) {
            $data = $this->_fetchData();
            Memory::set($key, $data);
        }

        $this->data = array_merge($this->data, $data);
    }

    /**
     * _fetchData
     *
     * @return null
     */
    private function _fetchData()
    {
        $data['currentAnnouncement'] = Announcement::getLatest();
        $data['currentNews'] = News::getLatest();
        $data['linkOfTheWeek'] = LinkOfTheWeek::getLatest();
        $data['myLinks'] = MyLink::getAllByUsername();//DFLT

        if (!empty($data['myLinks'])) {
            $data['myLinks'] = $data['myLinks']->toArray();
        }

        //sections have subsections, subsections have groups, groups have items... build a tree
        $data['sections'] = array(
            1 => array(
                'heading'     => '',
                'divId'       => 'worktools',
                'subsections' => array(),
            ),
            2 => array(
                'heading'     => '',
                'divId'       => 'toplinks',
                'subsections' => array(),
            ),
            3 => array(
                'heading'     => '',
                'divId'       => 'news',
                'subsections' => array(),
            ),
            4 => array(
                'heading'     => '',
                'divId'       => 'money',
                'subsections' => array(),
            ),
        );

        //get the items
        $items = Item::getHomePageItems();

        //organize the items by section, subsection, and group
        foreach ($items as $i) {
            $data['sections'][$i['sectionId']]['heading'] = $i['sectionTitle'];

            //format the item
            $item = array(
                'title'     => $i['title'],
                'url'       => $i['url'],
                'phone'     => $i['phoneNumber'],
                'external'  => $i['externalLink'] == 'Y',
                'multiLine' => $i['multipleLine'] == 'Y',
                'pdfInfo'   => '',
            );

            if ($i['isPdf'] == 'Y') {
                $item['pdfInfo'] = '(PDF ' . $i['pdfSize'] . ')';
            }

            if ($i['displayDisclaimer'] == 'Y') {
                $item['url'] = '/disclaimer?url=' . urlencode($item['url']);
            }

            $subsections = $data['sections'][$i['sectionId']]['subsections'];

            if (!isset($subsections[$i['subsectionId']])) {
                $subsections[$i['subsectionId']] = array(
                    'id'      => $i['subsectionId'],
                    'heading' => $i['subsectionTitle'],
                    'groups'  => array(),
                );
            }

            $groups = $subsections[$i['subsectionId']]['groups'];

            if (!isset($groups[$i['subsectionGroupId']])) {
                $groups[$i['subsectionGroupId']] = array(
                    'heading' => $i['subsectionGroupTitle'],
                    'items'   => array(),
                );
            }

            $groups[$i['subsectionGroupId']]['items'][] = $item;

            $subsections[$i['subsectionId']]['groups'] = $groups;
            $data['sections'][$i['sectionId']]['subsections'] = $subsections;
        }

        return $data;
    }
}
