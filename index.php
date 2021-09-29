<?php

require 'vendor/autoload.php';

use App\Router;

if ('GET' != $requestMehtod = $_SERVER['REQUEST_METHOD']) {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    die();
}

$router = new Router();

$uri = $_SERVER['REQUEST_URI'];
$queryStrings = $_GET;

$result = $router->route($uri, $queryStrings);

if (!is_array($result)) {
    echo json_encode(['message' => $result]);
    die();
}

if (array_key_exists('HTTP_ACCEPT', $_SERVER) && $_SERVER['HTTP_ACCEPT'] == 'text/xml') {
    toXML($result);
}

if (array_key_exists('HTTP_ACCEPT', $_SERVER) && $_SERVER['HTTP_ACCEPT'] == 'text/csv') {
    toCSV($result);
}

if (array_key_exists('HTTP_ACCEPT', $_SERVER) && $_SERVER['HTTP_ACCEPT'] == 'application/vnd.api+json') {
    toVND($result);
}

echo json_encode($result, JSON_PRETTY_PRINT);

function toXML(array $data): void
{
    $xml_data = new SimpleXMLElement('<?xml version="1.0"?><response></response>');
    foreach ($data as $key => $value) {
        $subnode = $xml_data->addChild("vessel");
        foreach ($value as $key => $value) {
            $subnode->addChild("$key", "$value");
        }
    }

    header("Content-type: text/xml;charset=utf-8");
    echo $xml_data->asXML();
    die();
}

function toCSV(array $data): void
{
    ob_start();
    header('Content-Type: text/plain;charset=UTF-8');
    $stream = fopen('php://output', 'w');

    $header = false;
    foreach ($data as $row) {
        if (empty($header)) {
            $header = array_keys((array) $row);
            fputcsv($stream, $header);
            $header = array_flip($header);
        }
        fputcsv($stream, array_merge($header, (array) $row));
    }

    header("Content-Type: application/csv");
    echo mb_convert_encoding(ob_get_clean(), 'SJIS', 'UTF-8');
    die();
}

function toVND(array $data): void
{

    $vndFormat = [
        'data' => []
    ];
    foreach ($data as &$value) {
        $vesselID = $value->id;
        unset($value->id);
        $value = [
            'type' => 'vessel',
            'id' => $vesselID,
            'attributes' => $value
        ];
        array_push($vndFormat['data'], $value);
    }
    echo json_encode($vndFormat, JSON_PRETTY_PRINT);
    die();
}
