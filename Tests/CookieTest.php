<?php

/**
 * @copyright  (C) 2013 Open Source Matters, Inc. <https://www.joomla.org>
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Input\Tests;

use Joomla\Filter\InputFilter;
use Joomla\Input\Cookie;
use Joomla\Input\Tests\Stubs\CookieDataStore;
use Joomla\Test\TestHelper;
use PHPUnit\Framework\TestCase;

/**
 * Test class for \Joomla\Input\Cookie.
 */
class CookieTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        require_once __DIR__ . '/Stubs/setcookie.php';
        CookieDataStore::reset();
    }

    /**
     * @testdox  Tests the input creates itself properly
     *
     * @covers   \Joomla\Input\Cookie
     * @uses     \Joomla\Input\Input
     */
    public function testConstructDefaultBehaviour()
    {
        $instance = new Cookie();

        $this->assertSame($_COOKIE, TestHelper::getValue($instance, 'data'), 'The Cookie input defaults to the $_COOKIE superglobal');
        $this->assertInstanceOf(InputFilter::class, TestHelper::getValue($instance, 'filter'), 'The Input object should create an InputFilter if one is not provided');
    }

    /**
     * @testdox  Tests the constructor with injected data
     *
     * @covers   \Joomla\Input\Cookie
     * @uses     \Joomla\Input\Input
     */
    public function testConstructDependencyInjection()
    {
        $src        = ['foo' => 'bar'];
        $mockFilter = $this->createMock(InputFilter::class);

        $instance = new Cookie($src, ['filter' => $mockFilter]);

        $this->assertSame($src, TestHelper::getValue($instance, 'data'));
        $this->assertSame($mockFilter, TestHelper::getValue($instance, 'filter'));
    }

    /**
     * @testdox  Tests that data is correctly set with the legacy signature
     *
     * @covers   \Joomla\Input\Cookie
     * @uses     \Joomla\Input\Input
     */
    public function testSetWithLegacySignature()
    {
        $mockFilter = $this->createMock(InputFilter::class);

        $instance = new Cookie([], ['filter' => $mockFilter]);
        $instance->set('foo', 'bar', 15);

        $this->assertTrue(CookieDataStore::has('foo'));
    }

    /**
     * @testdox  Tests that data is correctly set with the new signature
     *
     * @covers   \Joomla\Input\Cookie
     * @uses     \Joomla\Input\Input
     */
    public function testSetWithNewSignature()
    {
        $mockFilter = $this->createMock(InputFilter::class);

        $instance = new Cookie([], ['filter' => $mockFilter]);
        $instance->set('foo', 'bar', ['expire' => 15, 'samesite' => 'Strict']);

        $this->assertTrue(CookieDataStore::has('foo'));
    }
}
