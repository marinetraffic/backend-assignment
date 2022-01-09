<?php
/**
	 * Convert an array to XML
	 * @param array $data
	 * @param SimpleXMLElement $xml_data
	 */
function arrayToXml( $data, &$xml_data ) {
    foreach( $data as $key => $value ) {
        if( is_array($value) ) {
            if( is_numeric($key) ){
                $key = 'item'.$key; //dealing with <0/>..<n/> issues
            }
            $subnode = $xml_data->addChild($key);
            arrayToXml($value, $subnode);
        } else {
            $xml_data->addChild("$key",htmlspecialchars("$value"));
        }
     }
     
     return $xml_data->asXML();
}



?>