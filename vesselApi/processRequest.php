<?php
require_once(PROJECT_ROOT_PATH . 'fileLogger/FileLogger.php');

$lon_min=null;
$lon_max=null;
$lat_min=null;
$lat_max=null;
$time_min=null;
$time_max=null;
$strContentType='json';
$limit=50;


$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );


if ((isset($uri[3]) && $uri[3] != 'listAll' 
    && $uri[3] != 'getVessels' 
    && $uri[3] != 'loadFromJson') || !isset($uri[3])) {
    	$bad_request=true;
}

$strMethodName = $uri[3];


if ((isset($uri[4]) && $uri[4] != 'csv' 
    && $uri[4] != 'xml' 
    && $uri[4] != 'json' && $uri[4] != 'vndapijson')) {
    	$bad_request=true;
}

if(isset($uri[4]))
{
	$strContentType = $uri[4];
}


if (isset($_REQUEST['mmsi']))
{

	$query  = explode('&', $_SERVER['QUERY_STRING']);
	$params = array();
	
	foreach( $query as $param )
	{
		// prevent notice on explode() if $param has no '='
	  if (strpos($param, '=') === false) $param += '=';
	  
	  list($name, $value) = explode('=', $param, 2);
	  $decodedname = urldecode($name);
	  if ($decodedname == 'mmsi'){
	  	$params[$decodedname][] = urldecode($value);
	  }
	  
	}
}

if (isset($_REQUEST['limit']))
{
    $limit=filter_var( trim($_REQUEST['limit']) , FILTER_SANITIZE_STRING);
}


//if (isset($_REQUEST['mmsi']))
//{
//    $mmsi=filter_var( trim($_REQUEST['mmsi']) , FILTER_SANITIZE_STRING);
//}


if (isset($_REQUEST['lon_min']))
{
    $lon_min=filter_var( trim($_REQUEST['lon_min']) , FILTER_SANITIZE_STRING);
}
if (isset($_REQUEST['lon_max']))
{
    $lon_max=filter_var( trim($_REQUEST['lon_max']) , FILTER_SANITIZE_STRING);
}
if (isset($_REQUEST['lon_min']) && isset($_REQUEST['lon_max']))
{
	if($lon_min>$lon_max){
		$bad_request=true;
	}
		
}


if (isset($_REQUEST['lat_min']))
{
    $lat_min=filter_var( trim($_REQUEST['lat_min']) , FILTER_SANITIZE_STRING);
}
if (isset($_REQUEST['lat_max']))
{
    $lat_max=filter_var( trim($_REQUEST['lat_max']) , FILTER_SANITIZE_STRING);
}

if (isset($_REQUEST['lat_min']) && isset($_REQUEST['lat_max']))
{
	if($lat_min>$lat_max){
		$bad_request=true;
	}
		
}

if (isset($_REQUEST['time_min']))
{
    $time_min =filter_var( trim($_REQUEST['time_min']) , FILTER_SANITIZE_STRING);
}
if (isset($_REQUEST['time_max']))
{
    $time_max =filter_var( trim($_REQUEST['time_max']) , FILTER_SANITIZE_STRING);
}
if (isset($_REQUEST['time_min']) && isset($_REQUEST['time_max']))
{
	if($time_min>$time_max){
		$bad_request=true;
	}
		
}



?>