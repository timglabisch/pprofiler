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

    /** @return \Pprofiler\Timer */
    function getProfilerMock() {
        return $this->getMock('\Pprofiler\Timer');
    }

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

    function testEnd() {
        $timer = $this->getProfilerMock();
        $getTime = $timer->expects($this->any())->method('getTime');
        $getTime->will($this->returnValue(0.0));


        $this->profiler = new Profiler($timer);
        $t = $this->profiler->start('foo1');
        $getTime->will($this->returnValue(0.3));
        $t->end();

        $getTime->will($this->returnValue(0.4));

        $buffer = array();
        foreach($this->profiler as $t)
            /** @var $t TimeSpan */
            $buffer[] = $t->getRealTime();

        $this->assertEquals(array(0.3), $buffer);
    }

    function testSubProfiles() {
        $timer = $this->getProfilerMock();
        $getTime = $timer->expects($this->any())->method('getTime');
        $getTime->will($this->returnValue(0.0));

        $this->profiler = new Profiler($timer);
        $this->profiler->start('foo1');

        $getTime->will($this->returnValue(0.01));

        $query1 = $this->profiler->profile('db')->start('q1', 'sql1');
        $getTime->will($this->returnValue(0.1));
        $query11 = $this->profiler->profile('db')->start('q1', 'sql1.1');
        $getTime->will($this->returnValue(0.2));
        $query11->end();
        $query2 = $this->profiler->profile('db')->start('q2', 'sql2');
        $query2->end();

        $whatever = $this->profiler->profile('db')->start('whatever', array('a', 'b'));

        $getTime->will($this->returnValue(0.5));

        $buffer = array();
        foreach($this->profiler->getProfiles() as $profileName => $profile) {
            $buffer[$profileName] = array();
            foreach($profile as $t) {
                $buffer[$profileName][] = array($t->getName(), $t->getRealTime(), $t->getData());
            }
        }

        $this->assertEquals(array(
            'db' => array(
                array('q1', 0.49, 'sql1'),
                array('q1', 0.1, 'sql1.1'),
                array('q2', 0.0, 'sql2'),
                array('whatever', 0.3, array('a', 'b')),
            )
        ), $buffer);
    }

}