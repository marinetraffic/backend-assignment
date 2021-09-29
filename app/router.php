<?php

namespace App;

use App\Controllers\VesselController;
use App\Lib\LogRequest;

class Router
{
    public function route(string $path, array $options)
    {
        $path = explode('?', $path)[0];
        $logger = new LogRequest();

        $result = '';
        switch ($path) {
            case '/':
                if ($logger->rateLimit()) {
                    $result = $logger->nextRequestAllowed() . 'for next request';
                    break;
                }
                $logger->log();
                $vesselInstance = new VesselController();
                $result = $vesselInstance->findMany($options);
                break;

            default:
                $result = ["data" => "Not supported endpoint"];
                break;
        }

        return $result;
    }
}
