<?php

/**
 * @copyright  (C) 2013 Open Source Matters, Inc. <https://www.joomla.org>
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Input\Tests\Stubs;

if (\version_compare(PHP_VERSION, '7.3', '>=')) {
    /**
     * Stub.
     *
     * @param   string  $name     Name
     * @param   string  $value    Value
     * @param   array   $options  Expire
     *
     * @return  bool
     *
     * @since   1.1.4
     */
    function setcookie($name, $value, $options = [])
    {
        CookieDataStore::set($name, $value);

        return true;
    }
} else {
    /**
     * Stub.
     *
     * @param   string  $name      Name
     * @param   string  $value     Value
     * @param   int     $expire    Expire
     * @param   string  $path      Path
     * @param   string  $domain    Domain
     * @param   bool    $secure    Secure
     * @param   bool    $httpOnly  HttpOnly
     *
     * @return  bool
     *
     * @since   1.1.4
     */
    function setcookie($name, $value, $expire = 0, $path = '', $domain = '', $secure = false, $httpOnly = false)
    {
        CookieDataStore::set($name, $value);

        return true;
    }
}
