<?php

namespace Pprofiler;

use Pprofiler\Timer\TimeSpan;

class Profiler implements \IteratorAggregate {

    /** @var Timer */
    protected $timer;

    /** @var TimeSpan[] */
    protected $timeSpans = array();

    protected $profiles = array();

    function __construct(Timer $timer) {
        $this->timer = $timer;
    }

    /** @return static */
    protected function getOrCreateProfile($name, $timer) {
        if(!isset($this->profiles[$name])) {
            $this->profiles[$name] = new static($timer?$timer:$this->timer);
        }

        return $this->profiles[$name];
    }

    /** @return TimeSpan[] */
    protected function getTimeSpans() {
        return $this->timeSpans;
    }

    public function addTimeSpan(TimeSpan $timeSpan) {
        $this->timeSpans[] = $timeSpan;
    }

    /** @return static */
    function profile($name) {
        return $this->getOrCreateProfile($name, $timer);
    }

    /** @return TimeSpan */
    function start($name = '', $data = null) {

        $timeSpan = new TimeSpan($this->timer, null, null, $name, $data);
        $this->addTimeSpan($timeSpan);

        return $timeSpan;
    }

    /** @return TimeSpan */
    function getTimeSpan() {
        return $this->timeSpan;
    }

    function getIterator() {
        return new \ArrayIterator($this->timeSpans);
    }

}