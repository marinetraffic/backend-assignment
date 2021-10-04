<?php
require __DIR__ . "/inc/bootstrap.php";
//check if request limit is exceeded
$logger = new Logger();
$clientIP = $_SERVER['REMOTE_ADDR'];
if($logger->hasExceededRequests($clientIP))
{
    header("HTTP/1.1 429 Too Many Requests");
    echo "Too many requests";
    exit;
}
$strMethodName = "default";

if(isset($_GET['mmsi']))
{
    $strMethodName = "mmsi";
}
else if(isset($_GET['latFrom']) && isset($_GET['latTo']) && isset($_GET['lonFrom']) && isset($_GET['lonTo']))
{
    $strMethodName = "latLon";
}
else if(isset($_GET['since']) && isset($_GET['until']))
{
    $strMethodName = 'time';
}

require_once PROJECT_ROOT_PATH . "/Controller/VesselController.php";

$logger->log_request($clientIP);
$objFeedController = new VesselController();
$objFeedController->{$strMethodName}();
?>