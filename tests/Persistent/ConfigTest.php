<?php
/**
 * FrametekLight Framework (https://github.com/tekreme73/FrametekLight)
 *
 * @link		https://github.com/tekreme73/FrametekLight
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/FrametekLight/blob/master/LICENSE (MIT License)
 */
use FrametekLight\Persistent\Config;

class ConfigTest extends PHPUnit_Framework_TestCase
{

    protected $configs;

    public function setUp()
    {
        $this->configs = new Config("tests/_fake_app/config");
    }

    public function test_loadSuccess()
    {
        $this->assertNotEmpty($this->configs->all());
    }

    public function test_getConfig()
    {
        $this->assertNotEmpty($this->configs->value('app', []));
    }

    public function test_getPreciseConfig()
    {
        $this->assertEquals($this->configs->value('app.version'), '0.0');
        $this->assertEquals($this->configs->value('app.debug'), true);
    }
}
