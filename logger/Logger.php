<?php
require_once PROJECT_ROOT_PATH . "/utils/Database.php";
class Logger extends Database
{
    public function log_request($ip)
    {
        $this->executeStatement("INSERT INTO requests (ip) VALUES ('$ip')");
    }
    public function hasExceededRequests($ip) {
        $value = $this->select("SELECT count(id)>".REQUESTS_LIMIT." as r FROM requests WHERE ts >= current_timestamp() - INTERVAL 1 hour
        and ip = '$ip'");
        return $value[0]['r'];
        
    }
}

?>