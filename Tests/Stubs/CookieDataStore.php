<?php

/**
 * @copyright  (C) 2013 Open Source Matters, Inc. <https://www.joomla.org>
 * @license        GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Input\Tests\Stubs;

abstract class CookieDataStore
{
    private static $store = [];

    public static function reset(): void
    {
        self::$store = [];
    }

    public static function has(string $key): bool
    {
        return isset(self::$store[$key]);
    }

    public static function set(string $key, $value): void
    {
        self::$store[$key] = $value;
    }
}
