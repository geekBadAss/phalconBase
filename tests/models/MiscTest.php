<?php
/**
 * MiscTest
 *
 * Tests
 * @author  aidan lydon <aidanlydon@gmail.com>
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
        $root = '';

        $urls = array(
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
