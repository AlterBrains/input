<?php

/**
 * @copyright  (C) 2013 Open Source Matters, Inc. <https://www.joomla.org>
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Input\Tests;

use Joomla\Filter\InputFilter;
use Joomla\Input\Json;
use Joomla\Test\TestHelper;
use PHPUnit\Framework\TestCase;

/**
 * Test class for \Joomla\Input\Json.
 */
class JsonTest extends TestCase
{
    /**
     * @testdox  Tests the default constructor behavior
     *
     * @covers   \Joomla\Input\Json
     * @uses     \Joomla\Input\Input
     */
    public function testConstructDefaultBehaviour()
    {
        $instance = new Json();

        $this->assertEmpty(TestHelper::getValue($instance, 'data'), 'The JSON input defaults to php://input which should be empty in the test environment');
        $this->assertInstanceOf(InputFilter::class, TestHelper::getValue($instance, 'filter'), 'The Input object should create an InputFilter if one is not provided');
    }

    /**
     * @testdox  Tests the constructor with injected data
     *
     * @covers   \Joomla\Input\Json
     * @uses     \Joomla\Input\Input
     */
    public function testConstructDependencyInjection()
    {
        $src        = ['foo' => 'bar'];
        $mockFilter = $this->createMock(InputFilter::class);

        $instance = new Json($src, ['filter' => $mockFilter]);

        $this->assertSame($src, TestHelper::getValue($instance, 'data'));
        $this->assertSame($mockFilter, TestHelper::getValue($instance, 'filter'));
    }

    /**
     * @testdox  Tests the constructor when reading data from the $GLOBALS
     *
     * @covers   \Joomla\Input\Json
     * @uses     \Joomla\Input\Input
     *
     * @backupGlobals enabled
     */
    public function testConstructReadingFromGlobals()
    {
        $GLOBALS['HTTP_RAW_POST_DATA'] = '{"a":1,"b":2}';

        $instance = new Json();

        $this->assertSame(['a' => 1, 'b' => 2], TestHelper::getValue($instance, 'data'));
        $this->assertInstanceOf(InputFilter::class, TestHelper::getValue($instance, 'filter'), 'The Input object should create an InputFilter if one is not provided');
    }

    /**
     * @testdox  Tests the constructor when reading data from the $GLOBALS
     *
     * @covers   \Joomla\Input\Json
     * @uses     \Joomla\Input\Input
     *
     * @backupGlobals enabled
     */
    public function testgetRaw()
    {
        $GLOBALS['HTTP_RAW_POST_DATA'] = '{"a":1,"b":2}';

        $this->assertSame($GLOBALS['HTTP_RAW_POST_DATA'], (new Json())->getRaw());
    }
}
