<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use SimpleXMLElement;

class ArrayToXMLService{
    public function handle($data){
        $xml = new SimpleXMLElement('<root/>');

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $new_object = $xml->addChild($key);
                to_xml($new_object, $value);
            } else {
                // if the key is an integer, it needs text with it to actually work.
                if ($key != 0 && $key == (int) $key) {
                    $key = "key_$key";
                }

                $xml->addChild($key, $value);
            }
        }

        return $xml;
    }
}
