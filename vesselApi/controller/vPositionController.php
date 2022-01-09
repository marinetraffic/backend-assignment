<?php
class vPositionController extends BaseController
{
    /**
     * "/vessel/list" Endpoint - Get list of vessel positions
     */
    public function listAll($limit,$strContentType)
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $vPositionModel = new vPositionModel();
                $arrPositions = $vPositionModel->getAllPositions($limit);
                $responseData = json_encode($arrPositions);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
        	//for POST method only VND API JSON requests are permitted
        	$serverReqContent = $_SERVER["CONTENT_TYPE"];
        	if($serverReqContent != "application/vnd.api+json")
        	{
            	$strErrorDesc = 'Method not supported';
            	$strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        	}
        }
        require PROJECT_ROOT_PATH . "controller/vPositionControllerSendOut.php";
       
    }
    
    
    /**
     * "/vessel/loadFromJson" Endpoint - load list of vessel positions
     */
    public function loadFromJson()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        
        
        // Read the JSON file in PHP
        $ship_positions = file_get_contents(filename);
        // Convert the JSON String into PHP Array
        $decoded_json = json_decode($ship_positions, true); 
       
        
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $vPositionModel = new vPositionModel();
                $addedPositions = $vPositionModel->addPositions($decoded_json);
                $responseData = json_encode($addedPositions);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
                );
        }
    }
    
    public function getVessels($mmsi,$lon_min,$lon_max,$lat_min,$lat_max,$time_min,$time_max ,$strContentType)
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        
        if (strtoupper($requestMethod) == 'GET') {
            try {
                $vPositionModel = new vPositionModel();              
                $arrPositions = $vPositionModel->getPositions($mmsi, $lon_min,$lon_max,$lat_min,$lat_max,$time_min,$time_max);
                $responseData = json_encode($arrPositions);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
        	$serverReqContent = $_SERVER["CONTENT_TYPE"];
        	if($serverReqContent != "application/vnd.api+json")
        	{
            	$strErrorDesc = 'Method not supported';
            	$strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        	}
            
        }
        require PROJECT_ROOT_PATH . "controller/vPositionControllerSendOut.php";
        
        
    }
    
}

?>