<?php

namespace App\Lib;

use DateTime;
use DateInterval;

class LogRequest
{
    private $db;

    function __construct()
    {
        $dbInstance = Database::getInstance();
        $this->db = $dbInstance->getConnection();
    }

    public function log()
    {
        $ip = $this->getUserIpAddr();
        $insertQuery = "insert into logs (ip_address, date) values ('{$ip}', now())";
        $this->db->query($insertQuery);
    }

    public function rateLimit()
    {
        $ip = $this->getUserIpAddr();
        $selectQuery = "select count(*) from logs where ip_address='{$ip}' and date >= DATE_SUB(NOW(),INTERVAL 1 HOUR)";
        $result = $this->db->query($selectQuery);
        $count = mysqli_fetch_row($result)[0];
        return $count > 10;
    }

    public function nextRequestAllowed()
    {
        $ip = $this->getUserIpAddr();
        $maxDateQuery = "select min(date) from logs where ip_address='{$ip}' and date >= DATE_SUB(NOW(),INTERVAL 1 HOUR)";
        $result = $this->db->query($maxDateQuery);
        $lastDate = mysqli_fetch_row($result)[0];

        $lastRequestDate = new DateTime($lastDate);
        $nextRequestDate = $lastRequestDate->add(new DateInterval('PT1H'));
        $currentDate = new DateTime();
        $timeToElapse = $currentDate->diff($nextRequestDate);
        return $timeToElapse->format('%i minutes and %s seconds');
    }

    private function getUserIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}
