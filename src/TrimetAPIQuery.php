<?php

/**
 * Query the Trimet API and parse the response.
 */
class TrimetAPIQuery {
    public $appID;

    protected $ARRIVAL_URL = 'http://developer.trimet.org/ws/V1/arrivals';

    public function __construct($appID=APP_ID) {
        $this->appID = $appID;
    }

    protected function buildUrl($url, $query_args) {
        $query_args['appID'] = $this->appID;
        return $url . '?' . http_build_query($query_args);
    }

    protected function getResponse($url) {
        return file_get_contents($url);
    }

    protected function parseResponse($response) {
        return new SimpleXMLElement($response);
    }

    protected function query($url) {
        return $this->parseResponse(
            $this->getResponse($url));
    }

    public function getArrivals($locIDs) {
        $locations = array();
        $arrivals = array();

        if (!is_array($locIDs)) {
            $locIDs = array($locIDs);
        }

        // Build request and fetch response
        $url = $this->buildUrl($this->ARRIVAL_URL,
            array('locIDs' => implode(',', $locIDs)));
        $response = $this->query($url);

        // Marshall locations to our Trimet object types
        foreach ($response->location as $l) {
            $locid = (string)$l['locid'];
            $locations[$locid] = new TrimetLocation(
                $l['desc'],
                $l['dir'],
                $l['lat'],
                $l['lng'],
                $l['locid']);
        }

        // Marshall arrivals to our Trimet object types
        foreach ($response->arrival as $a) {
            $locid = (string)$a['locid'];
            $arrival = new TrimetArrival(
                $locations[$locid],
                $a['block'],
                $a['departed'],
                $a['dir'],
                $a['estimated'],
                $a['fullSign'],
                $a['piece'],
                $a['route'],
                $a['scheduled'],
                $a['shortSign'],
                $a['status'],
                $a['detour']
            );
            $arrivals[] = $arrival;
        }

        // Sort arrivals
        natsort($arrivals);
 
        return $arrivals;
    }
}

?>
