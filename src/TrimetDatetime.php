<?php

/**
 * Represents a Trimet time string.
 */
class TrimetDatetime extends Trimet {
    public $trimet_datetime;
    public $unix_datetime;
    public $formatted_datetime;

    public function __construct($datetime, $format='g:ia') {
        $this->trimet_datetime = (string)$datetime;
        $this->unix_datetime = $this->trimet_to_unix(
            $this->trimet_datetime);
        $this->formatted_datetime = date($format,
            $this->unix_datetime);
    }

    /**
     * Converts milliseconds to seconds.
     */
    private function trimet_to_unix($datetime) {
        return $datetime / 1000;
    }

    public function __toString() {
        return $this->formatted_datetime;
    }
}

?>
