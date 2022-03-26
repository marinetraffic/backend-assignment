<?php

use Src\Models\Requests;
use Src\Models\Vessels;
use Steampixel\Route;

header('Content-Type: application/json; charset=UTF-8');

Route::add(
    '/json',
    function () use ($basePath, $db) {
        $allow = (new Requests($db))->increaseAndCheck('/', $_SERVER['REMOTE_ADDR']);

        if ($allow) {
            $results = (new Vessels($db))->getAll();
        } else {
            http_response_code(403);
            echo json_encode('You have exceeded the maximum requests per hour. Please try again later.');
            exit;
        }

        http_response_code(200);
        if (count($results) > 0) {
            echo json_encode($results);
        } else {
            echo json_encode('No results found.');
        }
    }
);

Route::add(
    '/json/mmsi/(.*)',
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
            echo json_encode('You have exceeded the maximum requests per hour. Please try again later.');
            exit;
        }

        http_response_code(200);

        if (count($results) > 0) {
            echo json_encode($results);
        } else {
            echo json_encode('No results found.');
        }
    }
);

Route::add(
    '/json/lon/from/(.*)',
    function (string $fromLon) use ($basePath, $db) {
        $allow = (new Requests($db))->increaseAndCheck('/lon', $_SERVER['REMOTE_ADDR']);

        if ($allow) {
            $results = (new Vessels($db))->getByLonFrom((float) $fromLon);
        } else {
            http_response_code(403);
            echo json_encode('You have exceeded the maximum requests per hour. Please try again later.');
            exit;
        }

        http_response_code(200);

        if (count($results) > 0) {
            echo json_encode($results);
        } else {
            echo json_encode('No results found.');
        }
    }
);

Route::add(
    '/json/lon/to/(.*)',
    function (string $toLon) use ($basePath, $db) {
        $allow = (new Requests($db))->increaseAndCheck('/lon', $_SERVER['REMOTE_ADDR']);

        if ($allow) {
            $results = (new Vessels($db))->getByLonTo((float) $toLon);
        } else {
            http_response_code(403);
            echo json_encode('You have exceeded the maximum requests per hour. Please try again later.');
            exit;
        }

        http_response_code(200);

        if (count($results) > 0) {
            echo json_encode($results);
        } else {
            echo json_encode('No results found.');
        }
    }
);

Route::add(
    '/json/lat/from/(.*)',
    function (string $fromLon) use ($basePath, $db) {
        $allow = (new Requests($db))->increaseAndCheck('/lon', $_SERVER['REMOTE_ADDR']);

        if ($allow) {
            $results = (new Vessels($db))->getByLatFrom((float) $fromLon);
        } else {
            http_response_code(403);
            echo json_encode('You have exceeded the maximum requests per hour. Please try again later.');
            exit;
        }

        http_response_code(200);

        if (count($results) > 0) {
            echo json_encode($results);
        } else {
            echo json_encode('No results found.');
        }
    }
);

Route::add(
    '/json/lat/to/(.*)',
    function (string $toLon) use ($basePath, $db) {
        $allow = (new Requests($db))->increaseAndCheck('/lon', $_SERVER['REMOTE_ADDR']);

        if ($allow) {
            $results = (new Vessels($db))->getByLatTo((float) $toLon);
        } else {
            http_response_code(403);
            echo json_encode('You have exceeded the maximum requests per hour. Please try again later.');
            exit;
        }

        http_response_code(200);

        if (count($results) > 0) {
            echo json_encode($results);
        } else {
            echo json_encode('No results found.');
        }
    }
);

Route::add(
    '/json/lon/from/(.*)/to/(.*)',
    function (string $fromLon, string $toLon) use ($basePath, $db) {
        $allow = (new Requests($db))->increaseAndCheck('/lon', $_SERVER['REMOTE_ADDR']);

        if ($allow) {
            $results = (new Vessels($db))->getByLon((float) $fromLon, (float) $toLon);
        } else {
            http_response_code(403);
            echo json_encode('You have exceeded the maximum requests per hour. Please try again later.');
            exit;
        }

        http_response_code(200);

        if (count($results) > 0) {
            echo json_encode($results);
        } else {
            echo json_encode('No results found.');
        }
    }
);

Route::add(
    '/json/lat/from/(.*)/to/(.*)',
    function (string $fromLat, string $toLat) use ($basePath, $db) {
        $allow = (new Requests($db))->increaseAndCheck('/lat', $_SERVER['REMOTE_ADDR']);

        if ($allow) {
            $results = (new Vessels($db))->getByLat((float) $fromLat, (float) $toLat);
        } else {
            http_response_code(403);
            echo json_encode('You have exceeded the maximum requests per hour. Please try again later.');
            exit;
        }

        http_response_code(200);

        if (count($results) > 0) {
            echo json_encode($results);
        } else {
            echo json_encode('No results found.');
        }
    }
);

Route::add(
    '/json/timestamp/(.*)',
    function (string $timestamp) use ($basePath, $db) {
        $allow = (new Requests($db))->increaseAndCheck('/timestamp', $_SERVER['REMOTE_ADDR']);

        if ($allow) {
            $results = (new Vessels($db))->getByTimestamp((int) $timestamp);
        } else {
            http_response_code(403);
            echo json_encode('You have exceeded the maximum requests per hour. Please try again later.');

            exit;
        }

        http_response_code(200);

        if (count($results) > 0) {
            echo json_encode($results);
        } else {
            echo json_encode('No results found.');
        }
    }
);