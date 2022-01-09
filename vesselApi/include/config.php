<?php
define("PROJECT_ROOT_PATH", __DIR__ . "/../");
//Content Types
define("JSON", "json");
define("VNDAPIJSON", "vndapijson");
define("XML", "xml");
define("CSV", "csv");

//Filenames
define("csvFilename", "vessels.csv");
define("logfile","vesselApi.log");
define("filename", "ship_positions.json");


// include main configuration file
require_once PROJECT_ROOT_PATH . "include/db.php";
require_once PROJECT_ROOT_PATH . "include/utils.php";
require_once PROJECT_ROOT_PATH . "include/ratelimiter.php";


// include the base controller file
require_once PROJECT_ROOT_PATH . "controller/BaseController.php";

// include the use model file
require_once PROJECT_ROOT_PATH . "model/vPositionModel.php";
?>