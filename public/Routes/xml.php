<?php

use Src\Models\Requests;
use Src\Models\Vessels;
use Steampixel\Route;

header('Content-Type: text/xml; charset=UTF-8');

Route::add(
    '/xml',
    function () use ($basePath, $db) {
        $allow = (new Requests($db))->increaseAndCheck('/', $_SERVER['REMOTE_ADDR']);

        if ($allow) {
            $results = (new Vessels($db))->getAll();
        } else {
            http_response_code(403);
            echo simplexml_load_string('You have exceeded the maximum requests per hour. Please try again later.');
            exit;
        }

        http_response_code(200);

        if (count($results) > 0) {
            $xml = new SimpleXMLElement('<?xml version="1.0"?><data></data>');
            array_to_xml($results,$xml);
            print $xml->asXML();
        } else {
            echo simplexml_load_string('No results found.');
        }
    }
);

Route::add(
    '/xml/mmsi/(.*)',
    function (string $mmsi) use ($basePath, $db) {
        $allow = (new Requests($db))->increaseAndCheck('/mmsi', $_SERVER['REMOTE_ADDR']);

        if ($allow) {
            $mmsiArray = explode(',', $mmsi);

            if (count($mmsiArray) > 1) {
                $results = [];
                foreach ($mmsiArray as $mmsiLoop) {
                    $results = array_merge($results, (new Vessels($db))->getByMmsi((int) $mmsiLoop));
                }
            } else {
                $results = (new Vessels($db))->getByMmsi((int) $mmsi);
            }
        } else {
            http_response_code(403);
            echo simplexml_load_string('You have exceeded the maximum requests per hour. Please try again later.');
            exit;
        }

        http_response_code(200);

        if (count($results) > 0) {
            $xml = new SimpleXMLElement('<?xml version="1.0"?><data></data>');
            array_to_xml($results,$xml);
            print $xml->asXML();
        } else {
            echo simplexml_load_string('No results found.');
        }
    }
);

Route::add(
    '/xml/lon/from/(.*)',
    function (string $fromLon) use ($basePath, $db) {
        $allow = (new Requests($db))->increaseAndCheck('/lon', $_SERVER['REMOTE_ADDR']);

        if ($allow) {
            $results = (new Vessels($db))->getByLonFrom((float) $fromLon);
        } else {
            http_response_code(403);
            echo simplexml_load_string('You have exceeded the maximum requests per hour. Please try again later.');
            exit;
        }

        http_response_code(200);

        if (count($results) > 0) {
            $xml = new SimpleXMLElement('<?xml version="1.0"?><data></data>');
            array_to_xml($results,$xml);
            print $xml->asXML();
        } else {
            echo simplexml_load_string('No results found.');
        }
    }
);

Route::add(
    '/xml/lon/to/(.*)',
    function (string $toLon) use ($basePath, $db) {
        $allow = (new Requests($db))->increaseAndCheck('/lon', $_SERVER['REMOTE_ADDR']);

        if ($allow) {
            $results = (new Vessels($db))->getByLonTo((float) $toLon);
        } else {
            http_response_code(403);
            echo simplexml_load_string('You have exceeded the maximum requests per hour. Please try again later.');
            exit;
        }

        http_response_code(200);

        if (count($results) > 0) {
            $xml = new SimpleXMLElement('<?xml version="1.0"?><data></data>');
            array_to_xml($results,$xml);
            print $xml->asXML();
        } else {
            echo simplexml_load_string('No results found.');
        }
    }
);

Route::add(
    '/xml/lat/from/(.*)',
    function (string $fromLon) use ($basePath, $db) {
        $allow = (new Requests($db))->increaseAndCheck('/lon', $_SERVER['REMOTE_ADDR']);

        if ($allow) {
            $results = (new Vessels($db))->getByLatFrom((float) $fromLon);
        } else {
            http_response_code(403);
            echo simplexml_load_string('You have exceeded the maximum requests per hour. Please try again later.');
            exit;
        }

        http_response_code(200);

        if (count($results) > 0) {
            $xml = new SimpleXMLElement('<?xml version="1.0"?><data></data>');
            array_to_xml($results,$xml);
            print $xml->asXML();
        } else {
            echo simplexml_load_string('No results found.');
        }
    }
);

Route::add(
    '/xml/lat/to/(.*)',
    function (string $toLon) use ($basePath, $db) {
        $allow = (new Requests($db))->increaseAndCheck('/lon', $_SERVER['REMOTE_ADDR']);

        if ($allow) {
            $results = (new Vessels($db))->getByLatTo((float) $toLon);
        } else {
            http_response_code(403);
            echo simplexml_load_string('You have exceeded the maximum requests per hour. Please try again later.');
            exit;
        }

        http_response_code(200);

        if (count($results) > 0) {
            $xml = new SimpleXMLElement('<?xml version="1.0"?><data></data>');
            array_to_xml($results,$xml);
            print $xml->asXML();
        } else {
            echo simplexml_load_string('No results found.');
        }
    }
);

Route::add(
    '/xml/lon/from/(.*)/to/(.*)',
    function (float $fromLon, float $toLon) use ($basePath, $db) {
        $allow = (new Requests($db))->increaseAndCheck('/lon', $_SERVER['REMOTE_ADDR']);

        if ($allow) {
            $results = (new Vessels($db))->getByLon($fromLon, $toLon);
        } else {
            http_response_code(403);
            echo simplexml_load_string('You have exceeded the maximum requests per hour. Please try again later.');
            exit;
        }

        http_response_code(200);

        if (count($results) > 0) {
            $xml = new SimpleXMLElement('<?xml version="1.0"?><data></data>');
            array_to_xml($results,$xml);
            print $xml->asXML();
        } else {
            echo simplexml_load_string('No results found.');
        }
    }
);

Route::add(
    '/xml/lat/from/(.*)/to/(.*)',
    function (int $fromLat, int $toLat) use ($basePath, $db) {
        $allow = (new Requests($db))->increaseAndCheck('/lat', $_SERVER['REMOTE_ADDR']);

        if ($allow) {
            $results = (new Vessels($db))->getByLat($fromLat, $toLat);
        } else {
            http_response_code(403);
            echo simplexml_load_string('You have exceeded the maximum requests per hour. Please try again later.');
            exit;
        }

        http_response_code(200);

        if (count($results) > 0) {
            $xml = new SimpleXMLElement('<?xml version="1.0"?><data></data>');
            array_to_xml($results,$xml);
            print $xml->asXML();
        } else {
            echo simplexml_load_string('No results found.');
        }
    }
);

Route::add(
    '/xml/timestamp/(.*)',
    function (int $timestamp) use ($basePath, $db) {
        $allow = (new Requests($db))->increaseAndCheck('/timestamp', $_SERVER['REMOTE_ADDR']);

        if ($allow) {
            $results = (new Vessels($db))->getByTimestamp($timestamp);
        } else {
            http_response_code(403);
            echo simplexml_load_string('You have exceeded the maximum requests per hour. Please try again later.');
            exit;
        }

        http_response_code(200);

        if (count($results) > 0) {
            $xml = new SimpleXMLElement('<?xml version="1.0"?><data></data>');
            array_to_xml($results,$xml);
            print $xml->asXML();

        } else {
            echo simplexml_load_string('No results found.');
        }
    }
);


/**
 * @param $data
 * @param $xml_data
 * @return void
 */
function array_to_xml($data, &$xml_data ) {
    foreach( $data as $key => $value ) {
        if( is_array($value) ) {
            if( is_numeric($key) ){
                $key = 'item'.$key; //dealing with <0/>..<n/> issues
            }
            $subnode = $xml_data->addChild($key);
            array_to_xml($value, $subnode);
        } else {
            $xml_data->addChild("$key",htmlspecialchars("$value"));
        }
    }
}