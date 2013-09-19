[![Build Status](https://travis-ci.org/timglabisch/pprofiler.png?branch=master)](https://travis-ci.org/timglabisch/pprofiler)

# PProfiler

this is a very easy Profiler for PHP.


## example
````php

function testBasicProfile() {

    $timer = $this->getProfilerMock();
    $getTime = $timer->expects($this->any())->method('getTime');
    $getTime->will($this->returnValue(0.1));


    $this->profiler = new Profiler($timer);
    $this->profiler->start('foo1');
    $getTime->will($this->returnValue(0.15));
    $this->profiler->start('foo2');
    $getTime->will($this->returnValue(0.2));

    $this->profiler->start('foo3');
    $this->profiler->start('foo4');
    $getTime->will($this->returnValue(0.3));


    $buffer = array();
    foreach($this->profiler as $t)
        /** @var $t TimeSpan */
        $buffer[] = array($t->getName(), $t->getRealTime());

    $this->assertEquals(
        array(
            array('foo1', 0.2),
            array('foo2', 0.15),
            array('foo3', 0.1),
            array('foo4', 0.1),
        ),
        $buffer
    );
}

````

Want more? - Study the Unittests, there is a bit more like Profilers in Profilers :)