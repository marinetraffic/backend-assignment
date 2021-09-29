<?php

namespace App\Controllers;

use App\Models\Vessel;

class VesselController
{
    public function findMany(array $options)
    {
        $query = "select * from vessel_info";
        $whereClause = [];

        if (array_key_exists('mmsi', $options)) {
            $subQuery = $this->mmsiQuery($options['mmsi']);

            if (is_array($subQuery)) {
                http_response_code(400);
                return $subQuery['message'];
            }

            array_push($whereClause, $subQuery);
        }

        if (array_key_exists('lat', $options)) {
            $subQuery = $this->latQuery($options['lat']);
            if (is_array($subQuery)) {
                http_response_code(400);
                return $subQuery['message'];
            }

            array_push($whereClause, $subQuery);
        }

        if (array_key_exists('lon', $options)) {
            $subQuery = $this->lonQuery($options['lon']);
            if (is_array($subQuery)) {
                http_response_code(400);
                return $subQuery['message'];
            }

            array_push($whereClause, $subQuery);
        }

        if (array_key_exists('time', $options)) {
            $subQuery = $this->timeQuery($options['time']);
            if (is_array($subQuery)) {
                http_response_code(400);
                return $subQuery['message'];
            }

            array_push($whereClause, $subQuery);
        }

        if (count($whereClause)) {
            $query = $query . " where " . implode(' and ', $whereClause);
        }

        $vessel = new Vessel();
        return $vessel->findMany($query);
    }

    private function mmsiQuery(string $data)
    {
        if (strpos($data, '[') !== false) {
            return [
                'status' => false,
                'message' => 'mmsi filter must be comma seperated string'
            ];
        }

        return "mmsi in ({$data})";
    }

    private function latQuery(string $data)
    {
        if (strpos($data, '[') !== false) {
            return [
                'status' => false,
                'message' => 'lat filter must be comma seperated string'
            ];
        }

        $data = explode(',', $data);

        if (count($data) > 2) {
            return [
                'status' => false,
                'message' => 'lat filter must be comma seperated string with two values'
            ];
        }

        return "lat between {$data[0]} and {$data[1]}";
    }

    private function lonQuery(string $data)
    {
        if (strpos($data, '[') !== false) {
            return [
                'status' => false,
                'message' => 'lon filter must be comma seperated string'
            ];
        }

        $data = explode(',', $data);

        if (count($data) > 2) {
            return [
                'status' => false,
                'message' => 'lon filter must be comma seperated string with two values'
            ];
        }

        return "lon between {$data[0]} and {$data[1]}";
    }

    private function timeQuery(string $data)
    {
        if (strpos($data, '[') !== false) {
            return [
                'status' => false,
                'message' => 'time filter must be comma seperated string'
            ];
        }

        $data = explode(',', $data);

        if (count($data) > 2) {
            return [
                'status' => false,
                'message' => 'time filter must be comma seperated string with two values'
            ];
        }

        foreach ($data as &$val) {
            $val = strtotime($val);
        };

        return "timestamp between {$data[0]} and {$data[1]}";
    }
}
