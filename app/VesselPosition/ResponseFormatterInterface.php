<?php


namespace App\VesselPosition;


interface ResponseFormatterInterface
{

    public function format(string $contentType);

}
