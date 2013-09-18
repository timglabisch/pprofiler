<?php

namespace Pprofiler;

class Timer {
    function getTime() {
        return microtime(true);
    }
}