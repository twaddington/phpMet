<?php

/**
 * Wraps an XML representation of a Trimet
 * location.
 */
class TrimetLocation extends Trimet {
    public $desc;
    public $dir;
    public $lat;
    public $lng;
    public $locid;

    public function __construct($desc, $dir, $lat, $lng, $locid) {
        $this->desc = (string)$desc;
        $this->dir = (string)$dir;
        $this->lat = (string)$lat;
        $this->lng = (string)$lng;
        $this->locid = (string)$locid;
    }

    public function googleMapsUrl() {
        /* stub */
        return '';
    }

    public function __toString() {
        return $this->desc;
    }
}

?>
