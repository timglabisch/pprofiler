<?php

namespace Pprofiler\Timer;
use Pprofiler\Timer;

class TimeSpan {

    protected $start;
    protected $end;
    protected $name;
    protected $data;
    protected $timer;

    function __construct(Timer $timer, $start = null, $end = null, $name = null, $data = null) {
        $this->start = ($start?$start:$timer->getTime());
        $this->end = $end;
        $this->timer = $timer;
        $this->name = $name;
        $this->data = $data;
    }

    public function getStartTime() {
        return $this->start;
    }

    public function getEndTime() {
        return $this->end;
    }

    public function getRealTime() {
        $end = ($this->end !== null?$this->end:$this->timer->getTime());
        return $end - $this->start;
    }

    function end($time=null) {
        $this->end = ($time?$time:$this->timer->getTime());
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }
}