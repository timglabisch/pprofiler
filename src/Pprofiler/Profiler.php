<?php

namespace Pprofiler;

class Profiler {

    /** @var Timer */
    protected $timer;

    function __construct(Timer $timer) {
        $this->timer = $timer;
    }

}