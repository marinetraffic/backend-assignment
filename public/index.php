<?php

use Src\Models\Database;
use Src\Models\Requests;
use Src\Models\Vessels;
use Steampixel\Route;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Max-Age: 3600');

$basePath = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = str_replace($basePath, '', $uri);

require '../vendor/autoload.php';

try {
    $db = (new Database())->getConnection();
} catch (Exception $e) {
    echo 'Please ensure the MySQL server is up and running and able to accept connections.';
    exit;
}

if (!isset($_SESSION)) {
    session_start();
}

if (!array_key_exists('tablesSet', $_SESSION)) {
    try {
        (new Requests($db))->createTable();
        (new Vessels($db))->createTable();
    } catch (Exception $e) {
        echo 'Couldn\'t create necessary tables.';
        exit;
    }


    $_SESSION['tablesSet'] = 1;
}

$format = substr($uri, 0, 5);

switch ($format) {
    case '/xml/':
    case '/xml':
        include 'Routes/xml.php';
        break;
    case '/csv/':
    case '/csv':
        include 'Routes/csv.php';
        break;
    case '/json':
    default:
    include 'Routes/json.php';
        $sendType = 'json';
        break;
}

Route::add(
    '/(.*)',
    function (string $url) use ($basePath, $db) {
        (new Requests($db))->increaseAndCheck(sprintf('/%s', $url), $_SERVER['REMOTE_ADDR']);

        http_response_code(404);
        echo json_encode('The url doesn\'t exist. Check your spelling and try again.');
        exit;
    }
);

Route::run($basePath);