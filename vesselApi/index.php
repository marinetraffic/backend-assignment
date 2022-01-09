<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

date_default_timezone_set('Europe/Athens');
session_start();
require  __DIR__ .'/include/config.php'; 

require_once(PROJECT_ROOT_PATH . 'fileLogger/Compatibility.php');
require_once(PROJECT_ROOT_PATH . 'fileLogger/FileLogger.php');

use fileLogger\Compatibility;
use fileLogger\CompatibilityException;
use fileLogger\FileLogger;


//check php version for file logger
try {
    $compat = Compatibility::check();
} catch(CompatibilityException $e){
		$log->log($e->getMessage().' '.$_SERVER['REQUEST_URI'], FileLogger::WARNING);
    	die($e->getMessage());
}
$log = new FileLogger(PROJECT_ROOT_PATH .'logs/'.logfile);



//start rate limiter
$rateLimiter = new RateLimiter($_SERVER["REMOTE_ADDR"]);
$limitreqs = 10;				//	number of connections to limit user to per $minutes
$minutes = 60;				//	number of $minutes to check for.
$seconds = floor($minutes * 60);	//	retry after $minutes in seconds.

try {
	$rateLimiter->limitRequestsInMinutes($limitreqs, $minutes);
} catch (RateExceededException $e) {
	/* comment this out so you can test manually without being blocked*/
	header("HTTP/1.1 429 Too Many Requests");
	header(sprintf("Retry-After: %d", $seconds));
	$data = 'Rate Limit Exceeded ';
	$log->log("INFO:".$data.' REMOTEIP:'.$_SERVER["REMOTE_ADDR"].' REQUEST:'.$_SERVER['REQUEST_URI'], FileLogger::FATAL);
	die (json_encode($data));*/
}

//process request
$bad_request=false;
require PROJECT_ROOT_PATH . "processRequest.php";
if($bad_request){
	$log->log('BAD REQUEST:'.$_SERVER['REQUEST_URI'], FileLogger::ERROR);
    header("HTTP/1.1 404 Not Found");
    exit();
}
$log->log('REQUEST:'.$_SERVER['REQUEST_URI'], FileLogger::NOTICE);



//retrieve data based on request
require PROJECT_ROOT_PATH . "/controller/vPositionController.php";

$objFeedController = new vPositionController();
if($strMethodName=="getVessels")
{
    $objFeedController->{$strMethodName}($params['mmsi'],$lon_min,$lon_max,$lat_min,$lat_max,$time_min,$time_max,$strContentType);
}
else {
    $objFeedController->{$strMethodName}($limit,$strContentType);
}
?>