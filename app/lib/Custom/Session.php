<?php
/**
 * Session
 *
 * @package Lib
 * @author  aidan lydon <aidanlydon@gmail.com>
 */
class Session extends Base
{
    /**
     * get
     *
     * @param string $var
     *
     * @return mixed
     */
    public static function get($var)
    {
        $ret = false;

        if (isset($_SESSION[$var])) {
            $ret = $_SESSION[$var];
        }

        return $ret;
    }

    /**
     * set
     *
     * @param string $var   - session variable name
     * @param mixed  $value - session variable value
     *
     * @return null
     */
    public static function set($var, $value = null)
    {
        if (is_array($var)) {
            foreach ($var as $key => &$val) {
                $_SESSION[$key] = $val;
            }
        } else {
            $_SESSION[$var] = $value;
        }
    }

    /**
     * destroy
     *
     * @return null
     */
    public static function destroy()
    {
        $_SESSION = array();
    }

    /**
     * isUserLoggedIn
     *
     * @return boolean
     */
    public static function isUserLoggedIn()
    {
        return isset($_SESSION['userId']) && !empty($_SESSION['userId']);
    }

    /**
     * setRedirectUrl
     *
     * @param string $url
     *
     * @return null
     */
    public static function setRedirectUrl($url)
    {
        $_SESSION['redirectUrl'] = $url;
    }

    /**
     * getRedirectUrl
     *
     * @return string
     */
    public static function getRedirectUrl()
    {
        if (isset($_SESSION['redirectUrl'])) {
            $url = $_SESSION['redirectUrl'];
            unset($_SESSION['redirectUrl']);

            if (substr($url, 0, 1) == '/') {
                $url = substr($url, 1);
            }

        } else {
            $url = '';
        }

        return $url;
    }
}
