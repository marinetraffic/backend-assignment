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

    public function arrayToCSV($array, $path) {
        $fh = fopen($path, 'w');
        
        if (is_array($array)) {
            foreach ($array as $line) {
                foreach ($line as $key => $value) 
                    if (is_array($value)) 
                        $line[$key] = $value[0];
 
                if (is_array($line)) 
                    fputcsv($fh,$line);
            }
        }

        fclose($fh);
        return $fh;
    }
}