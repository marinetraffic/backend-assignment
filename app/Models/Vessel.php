<?php

namespace App\Models;

use App\Lib\Database;

class Vessel
{
    public function findMany(string $filter): array
    {
        $dbInstance = Database::getInstance();
        $db = $dbInstance->getConnection();
        $result = $db->query($filter);
        $resultArray = [];
        while ($obj = $result->fetch_object()) {
            array_push($resultArray, $obj);
        }

        return $resultArray;
    }
}
