A simple PHP library for interacting with the Portland, Oregon based
[TriMet API](http://developer.trimet.org/).

## Usage

...

Get upcoming arrivals for a stop by location id:

    <?php

    require_once('./phpMet/src/Trimet.php');

    $api = new TrimetAPIQuery('my_application_token');
    $arrivals = $api->getArrivals(TrimetAPIQuery::sanitizeLocationID(1448));

    print_r($arrivals);

    ?>

Get nearby stops:

    <?php

    require_once('./phpMet/src/Trimet.php');

    $api = new TrimetAPIQuery('my_application_token');

    $lat = 42.123;
    $lng = -122.123;
    $radius = 25; // meters
    $stops = $api->getStops($lat, $lng, $radius);

    print_r($stops);

    ?>

## Contributing

Please feel free to fork this library and submit pull requests. I'm not
really actively maintaining it anymore, but I'm happy to accept contributions.

In the future I might consider writing a Django wrapper for the TriMet API.
