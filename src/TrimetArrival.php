<?php

/**
 * Wraps an XML representation of a Trimet
 * arrival.
 */
class TrimetArrival extends Trimet {
    public $block;
    public $dir;
    public $fullSign;
    public $piece;
    public $route;
    public $shortSign;
    public $status;
    public $detour;

    public $location;

    public $departed;
    public $scheduled;
    public $estimated;
    public $arriving;

    public function __construct($location,
            $block,
            $departed,
            $dir,
            $estimated,
            $fullSign,
            $piece,
            $route,
            $scheduled,
            $shortSign,
            $status,
            $detour) {
        $this->block = (string)$block;
        $this->dir = (string)$dir;
        $this->fullSign = (string)$fullSign;
        $this->piece = (string)$piece;
        $this->route = (string)$route;
        $this->shortSign = (string)$shortSign;
        $this->status = (string)$status;
        $this->detour = (string)$detour; 

        $this->location = $location;

        $this->departed = new TrimetDatetime($departed);
        $this->scheduled = new TrimetDatetime($scheduled);
        $this->estimated = new TrimetDatetime($estimated);

        $this->arriving = $this->calculateArrivalTime();
    }

    /**
     * Calculate estimated arrival time.
     */
    protected function calculateArrivalTime() {
        if ($this->isScheduled()) {
            return $this->scheduled->unix_datetime - time();
        }
        return $this->estimated->unix_datetime - time();
    }

    /**
     * Return estimated arrival time in minutes
     */
    public function getArrivalTime($format='i') {
        $time = round($this->arriving / 60);
        if ($time < 0) {
            return '-' . $time;
        } else {
            return $time;
        }
    }

    public function isScheduled() {
        return $this->status == 'scheduled';
    }

    /**
     * Return a brief description used for sorting arrivals
     */
    public function __toString() {
        $string = '';
        $arrival_time = $this->getArrivalTime();

        if ($arrival_time < 0) {
            $string = '%s departed %s %d minutes ago';
        } else {
            $string = '%s arriving at %s in %d minutes';
        }

        return sprintf($string,
            $this->route, $this->location, abs($arrival_time));
    }
}

?>
