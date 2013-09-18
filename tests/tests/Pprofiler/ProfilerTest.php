<?php

namespace tests\Pprofiler;
use Pprofiler\Profiler;

class ProfilerTest extends \PHPUnit_Framework_TestCase {

    /** @var Profiler */
    protected $profiler;

    function setUp() {
        $this->profiler = new Profiler();
    }

    function testFoo() {

        $this->assertFalse(false);
    }

}