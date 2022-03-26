<?php

use Src\Models\Requests;
use Src\Models\Vessels;
use Steampixel\Route;

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename=records.csv');
http_response_code(200);

Route::add(
    '/csv',
    function () use ($basePath, $db) {
        $allow = (new Requests($db))->increaseAndCheck('/', $_SERVER['REMOTE_ADDR']);

        if ($allow) {
            $results = (new Vessels($db))->getAll();
        } else {
            $output = fopen('php://output', 'w');
            fputcsv($output, ['You have exceeded the maximum requests per hour. Please try again later.']);
            fclose($output);
            exit;
        }

        $output = fopen('php://output', 'wb');
        if (count($results) > 0) {
            foreach ($results as $row){
                fputcsv($output, $row);
            }
        } else {
            fputcsv($output, ['No results found.']);
        }
        fclose($output);
    }
);

Route::add(
    '/csv/mmsi/(.*)',
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
            $output = fopen('php://output', 'w');
            fputcsv($output, ['You have exceeded the maximum requests per hour. Please try again later.']);
            fclose($output);
            exit;
        }

        $output = fopen('php://output', 'wb');
        if (count($results) > 0) {
            foreach ($results as $row){
                fputcsv($output, $row);
            }
        } else {
            fputcsv($output, ['No results found.']);
        }
        fclose($output);
    }
);

Route::add(
    '/csv/lon/from/(.*)',
    function (string $fromLon) use ($basePath, $db) {
        $allow = (new Requests($db))->increaseAndCheck('/lon', $_SERVER['REMOTE_ADDR']);

        if ($allow) {
            $results = (new Vessels($db))->getByLonFrom((float) $fromLon);
        } else {
            $output = fopen('php://output', 'w');
            fputcsv($output, ['You have exceeded the maximum requests per hour. Please try again later.']);
            fclose($output);
            exit;
        }

        $output = fopen('php://output', 'wb');
        if (count($results) > 0) {
            foreach ($results as $row){
                fputcsv($output, $row);
            }
        } else {
            fputcsv($output, ['No results found.']);
        }
        fclose($output);
    }
);

Route::add(
    '/csv/lon/to/(.*)',
    function (string $toLon) use ($basePath, $db) {
        $allow = (new Requests($db))->increaseAndCheck('/lon', $_SERVER['REMOTE_ADDR']);

        if ($allow) {
            $results = (new Vessels($db))->getByLonTo((float) $toLon);
        } else {
            $output = fopen('php://output', 'w');
            fputcsv($output, ['You have exceeded the maximum requests per hour. Please try again later.']);
            fclose($output);
            exit;
        }

        $output = fopen('php://output', 'wb');
        if (count($results) > 0) {
            foreach ($results as $row){
                fputcsv($output, $row);
            }
        } else {
            fputcsv($output, ['No results found.']);
        }
        fclose($output);
    }
);

Route::add(
    '/csv/lat/from/(.*)',
    function (string $fromLon) use ($basePath, $db) {
        $allow = (new Requests($db))->increaseAndCheck('/lon', $_SERVER['REMOTE_ADDR']);

        if ($allow) {
            $results = (new Vessels($db))->getByLatFrom((float) $fromLon);
        } else {
            $output = fopen('php://output', 'w');
            fputcsv($output, ['You have exceeded the maximum requests per hour. Please try again later.']);
            fclose($output);
            exit;
        }

        $output = fopen('php://output', 'wb');
        if (count($results) > 0) {
            foreach ($results as $row){
                fputcsv($output, $row);
            }
        } else {
            fputcsv($output, ['No results found.']);
        }
        fclose($output);
    }
);

Route::add(
    '/csv/lat/to/(.*)',
    function (string $toLon) use ($basePath, $db) {
        $allow = (new Requests($db))->increaseAndCheck('/lon', $_SERVER['REMOTE_ADDR']);

        if ($allow) {
            $results = (new Vessels($db))->getByLatTo((float) $toLon);
        } else {
            $output = fopen('php://output', 'w');
            fputcsv($output, ['You have exceeded the maximum requests per hour. Please try again later.']);
            fclose($output);
            exit;
        }

        $output = fopen('php://output', 'wb');
        if (count($results) > 0) {
            foreach ($results as $row){
                fputcsv($output, $row);
            }
        } else {
            fputcsv($output, ['No results found.']);
        }
        fclose($output);
    }
);

Route::add(
    '/csv/lon/from/(.*)/to/(.*)',
    function (float $fromLon, float $toLon) use ($basePath, $db) {
        $allow = (new Requests($db))->increaseAndCheck('/lon', $_SERVER['REMOTE_ADDR']);

        if ($allow) {
            $results = (new Vessels($db))->getByLon($fromLon, $toLon);
        } else {
            $output = fopen('php://output', 'w');
            fputcsv($output, ['You have exceeded the maximum requests per hour. Please try again later.']);
            fclose($output);
            exit;
        }

        $output = fopen('php://output', 'wb');
        if (count($results) > 0) {
            foreach ($results as $row){
                fputcsv($output, $row);
            }
        } else {
            fputcsv($output, ['No results found.']);
        }
        fclose($output);
    }
);

Route::add(
    '/csv/lat/from/(.*)/to/(.*)',
    function (int $fromLat, int $toLat) use ($basePath, $db) {
        $allow = (new Requests($db))->increaseAndCheck('/lat', $_SERVER['REMOTE_ADDR']);

        if ($allow) {
            $results = (new Vessels($db))->getByLat($fromLat, $toLat);
        } else {
            $output = fopen('php://output', 'w');
            fputcsv($output, ['You have exceeded the maximum requests per hour. Please try again later.']);
            fclose($output);
            exit;
        }

        $output = fopen('php://output', 'wb');
        if (count($results) > 0) {
            foreach ($results as $row){
                fputcsv($output, $row);
            }
        } else {
            fputcsv($output, ['No results found.']);
        }
        fclose($output);
    }
);

Route::add(
    '/csv/timestamp/(.*)',
    function (int $timestamp) use ($basePath, $db) {
        $allow = (new Requests($db))->increaseAndCheck('/timestamp', $_SERVER['REMOTE_ADDR']);

        if ($allow) {
            $results = (new Vessels($db))->getByTimestamp($timestamp);
        } else {
            $output = fopen('php://output', 'w');
            fputcsv($output, ['You have exceeded the maximum requests per hour. Please try again later.']);
            fclose($output);
            exit;
        }

        $output = fopen('php://output', 'wb');
        if (count($results) > 0) {
            foreach ($results as $row){
                fputcsv($output, $row);
            }
        } else {
            fputcsv($output, ['No results found.']);
        }
        fclose($output);
    }
);