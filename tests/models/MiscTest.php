<?php
/**
 * MiscTest
 *
 * PHP Version 5.3
 *
 * @package   Tests
 * @author    aidan lydon <alyo@loc.gov>
 * @copyright 2014 The Library of Congress
 * @license   Copyright 2014 The Library of Congress
 * @version   $Id:$
 * @link      TBD
 * @since     Sept 24, 2014
 */
class MiscTest extends BaseUnitTest
{
    /**
     * testAllUrls - this test is included for the purpose of finding issues that get logged in the
     * apache logs. The error log should be empty
     *
     * @return null
     */
    public function testAllUrls()
    {
        $root = 'http://int.local/';

        $urls = array(
            'announcements',
            'announcements/rss',
            'disclaimer',
            'door-closures',
            'floor-plans',
            'forms',
            'intranets',
            'link-of-the-week',
            'link-of-the-week/suggest',
            'link-of-the-week/submitted',
            'maintenance',
            'new-on-loc',
            'news',
            'news/rss',
            'page/blah',
            'page/clubs',
            'page/labor-orgs',
            'page/feeds',
            'page/org-charts',
            'page/web-policy',
            'standard-disclaimer',
            //TODO: auth, user, admin interface
        );

        $ch = curl_init($root);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);

        foreach ($urls as $url) {
            $ch = curl_init($root . $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($ch);
            curl_close($ch);
        }
    }
}
