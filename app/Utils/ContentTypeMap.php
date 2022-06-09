<?php

namespace App\Utils;

use App\Adapters\Adapter;
use App\Adapters\CSVAdapter;
use App\Adapters\JSONAdapter;
use App\Adapters\LDJSONAdapter;
use App\Adapters\XmlAdapter;

class ContentTypeMap
{
    const SIMPLE_JSON = "application/json";
    const LD_JSON = "application/ld+json";
    const CSV = "text/csv";
    const XML = "application/xml";

    const accept_to_handler_map = [
        ContentTypeMap::SIMPLE_JSON => JSONAdapter::class,
        ContentTypeMap::XML => XmlAdapter::class,
        ContentTypeMap::CSV => CSVAdapter::class,
        ContentTypeMap::LD_JSON => LDJSONAdapter::class
    ];

    public static function getAdapter($content_type): ?Adapter
    {
        if (array_key_exists($content_type, static::accept_to_handler_map)) {
            $class =  static::accept_to_handler_map[$content_type];
            return new $class();
        }
        return null;
    }

}
