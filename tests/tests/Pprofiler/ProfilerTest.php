<?php

namespace tests\Pprofiler;
use Pprofiler\Profiler;
use Pprofiler\Timer;
use Pprofiler\Timer\TimeSpan;

class ProfilerTest extends \PHPUnit_Framework_TestCase {

    /** @var Profiler */
    protected $profiler;

    function setUp() {
        $timer = new Timer();
        $this->profiler = new Profiler($timer);
    }

    function testFoo() {
        $this->profiler->start('foo');
        $this->profiler->start('foo');
        $this->profiler->start('foo2');
        sleep(1);

        $this->profiler->start('foo3');

        foreach($this->profiler as $t)
            /** @var $t TimeSpan */
            echo $t->getName() .': '. $t->getRealTime()."\n";
    }

}