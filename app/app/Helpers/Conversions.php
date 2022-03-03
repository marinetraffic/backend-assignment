<?php 

namespace App\Helpers;

class Conversions {
    public function arrayToXml($data, &$xml_data) {
        foreach($data as $key => $value) {
            if(is_array($value)) {
                if(is_numeric($key))
                    $key = 'item'.$key;
                
                $subnode = $xml_data->addChild($key);
                $this->arrayToXml($value, $subnode);
            } else {
                $xml_data->addChild("$key", htmlspecialchars("$value"));
            }
        }
    }
}