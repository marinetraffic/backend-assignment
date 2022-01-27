<?php
require_once 'app/Vessels.php';

$vessels = new Vessels();
$results = $vessels->index();

header('Content-Type: application/json; charset=utf-8');
echo count($results) ? json_encode($results) : ['0 Results'];
