<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Helpers\Conversions;

class ConversionsTest extends TestCase {

    public function testArrayToXML() {
        $arr = [
            [ 
                "mmsi"=>247039300, "status"=>0, "stationId"=>81, "speed"=>180, 
                "lon"=>15.4415, "lat"=>42.75178, "course"=>144, "heading"=>144, 
                "rot"=>"", "timestamp"=>1372683960 
            ],
            [ 
                "mmsi"=>247039300, "status"=>0, "stationId"=>81, "speed"=>180, 
                "lon"=>15.4415, "lat"=>42.75178, "course"=>144, "heading"=>144, 
                "rot"=>"", "timestamp"=>1372683960 
            ]
        ];


        $xml = new \SimpleXMLElement('<root/>');
        $conversions = new Conversions();
        $conversions->arrayToXml($arr, $xml);
        $renderedXML = $xml->asXML();

        $this->assertTrue($renderedXML != '');
        $this->assertTrue(substr($renderedXML, 0, 5) == '<?xml');  
    }

    public function testArrayToCSV() {
        $arr = [
            [ 
                "mmsi"=>247039300, "status"=>0, "stationId"=>81, "speed"=>180, 
                "lon"=>15.4415, "lat"=>42.75178, "course"=>144, "heading"=>144, 
                "rot"=>"", "timestamp"=>1372683960 
            ],
            [ 
                "mmsi"=>247039300, "status"=>0, "stationId"=>81, "speed"=>180, 
                "lon"=>15.4415, "lat"=>42.75178, "course"=>144, "heading"=>144, 
                "rot"=>"", "timestamp"=>1372683960 
            ]
        ];

        $path = dirname(__DIR__, 2)."/public/temp/response_".time().".csv";
        $conversions = new Conversions();
        $csv = $conversions->arrayToCSV($arr, $path);

        $this->assertTrue($csv != '');
        $this->assertTrue(file_exists($path));
    }
}
