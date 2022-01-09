<?php
// send output
        if (!$strErrorDesc) 
        {
        	if($strContentType == 'json')
        	{
        		$this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                );
        	}
        	elseif ($strContentType == 'csv')
        	{
				$this->download_csv_results($arrPositions,csvFilename);
        	}
        	elseif ($strContentType == 'xml')
        	{
        		$xml = new SimpleXMLElement('<?xml version="1.0"?><data></data>');
				$responseData = arrayToXml($arrPositions, $xml);

        		$this->sendOutput(
                $responseData,
                array('Content-Type: text/xml charset=utf-8', 'HTTP/1.1 200 OK')
                );
        	}
        	elseif ($strContentType == 'vndapijson')
        	{
        		$this->sendOutput(
                $responseData,
                array('Content-Type: application/vnd.api+json', 'Accept: application/vnd.api+json')
                );
        	}
        	else
        	{ 
        		$this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                );
        	}
            
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
                );
        }
?>