<?php
/**
 * FrametekLight Framework (https://github.com/tekreme73/FrametekLight)
 *
 * @link		https://github.com/tekreme73/FrametekLight
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/FrametekLight/blob/master/LICENSE (MIT License)
 */
use FrametekLight\Http\Get;

class GetTest extends PHPUnit_Framework_TestCase
{

    protected $http_get;

    public function setUp()
    {
        $this->http_get = new Get();
    }

    public function test_all()
    {
        $this->assertEmpty($this->http_get->all());
    }

    public function test_hasnt()
    {
        $this->assertFalse($this->http_get->has("azzz"));
    }

    public function test_setAll()
    {
        $this->http_get->setAll(array(
            'name' => 'bob'
        ));
        $this->assertEquals(array(
            'name' => 'bob'
        ), $this->http_get->all());
    }

    public function test_has()
    {
        $this->http_get->setAll(array(
            'name' => 'bob'
        ));
        $this->assertTrue(isset($this->http_get['name']));
    }

    public function test_set()
    {
        $this->http_get->set('bob', 42);
        $this->assertTrue(isset($this->http_get['bob']));
    }

    public function test_get()
    {
        $this->http_get->setAll(array(
            'name' => 'bob'
        ));
        $this->assertEquals('bob', $this->http_get['name']);
    }

    public function test_contains()
    {
        $this->http_get->setAll(array(
            'name' => 63,
            'account' => array(
                'bobby' => array(
                    'bob'
                )
            )
        ));
        $this->assertFalse($this->http_get->contains('63'));
        $this->assertTrue($this->http_get->contains('63', FALSE));
        $this->assertTrue($this->http_get->contains(63));
        
        $this->assertFalse($this->http_get->contains(array(
            'bobby' => array(
                'abcde'
            )
        )));
        $this->assertTrue($this->http_get->contains(array(
            'bobby' => array(
                'bob'
            )
        )));
        $this->assertTrue($this->http_get->contains('bob'));
    }
}
