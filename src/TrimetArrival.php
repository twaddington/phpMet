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

    protected $location;

    protected $departed;
    protected $scheduled;
    protected $estimated;
    protected $arriving;

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

        $this->arriving = $this->calculate_arrival_time();
    }

    /**
     * Calculate estimated arrival in minutes.
     */
    public function calculate_arrival_time($format='i') {
        $timedelta = $this->estimated->unix_datetime - time();
        $time = date($format, $timedelta);
        
        if ($timedelta < 0) {
            return '-' . $time;
        }
        else {
            return $time;
        }
    }

    public function __toString() {
        $string = '';

        if ($this->arriving < 0) {
            $string = '%s departed %s %d minutes ago';
        }
        else {
            $string = '%s arriving at %s in %d minutes';
        }

        return sprintf($string,
            $this->shortSign, $this->location, abs($this->arriving));
    }
}

?>
