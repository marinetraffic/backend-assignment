<?php
class VesselController extends BaseController
{
    private $formats = array("json", "xml", "csv");
    private $outputHeaders = array(
        "json" => array('Content-Type: application/json', 'HTTP/1.1 200 OK'),
        "xml" => array('Content-Type: application/xml', 'HTTP/1.1 200 OK'),
        "csv" => array('Content-Type: text/csv', 'HTTP/1.1 200 OK')
    );
    public function default() 
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        $outputFormat = "json";
        if(isset($_GET['format']) &&  in_array($_GET['format'], $this->formats))
        {
            $outputFormat = $_GET['format'];
        }
        $outputFormatMethod = $outputFormat . "_encode";
        if(strtoupper($requestMethod) == 'GET')
        {
            try
            {
                $vesselModel = new Vessel();
                $arrVessel = $vesselModel->getVessels();
                $responseData = Exporters::{$outputFormatMethod}($arrVessel);
            }
            catch(Error $e)
            {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        }
        else
        {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                $this->outputHeaders[$outputFormat]
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
    public function mmsi()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        $mmsi = $_GET['mmsi'];

        if(strtoupper($requestMethod) == 'GET')
        {
            try
            {
                $vesselModel = new Vessel();

                $arrVessel = $vesselModel->getVessel($mmsi);
                $responseData = json_encode($arrVessel);
            }
            catch(Error $e)
            {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        }
        else
        {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
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
    public function latLon()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        $latFrom = $_GET['latFrom'];
        $latTo = $_GET['latTo'];
        $lonFrom = $_GET['lonFrom'];
        $lonTo = $_GET['lonTo'];

        if(strtoupper($requestMethod) == 'GET')
        {
            try
            {
                $vesselModel = new Vessel();

                $arrVessel = $vesselModel->getVesselFromLatAndLong($latFrom, $latTo, $lonFrom, $lonTo);
                $responseData = json_encode($arrVessel);
            }
            catch(Error $e)
            {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        }
        else
        {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
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
    public function time()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrQueryStringParams = $this->getQueryStringParams();
        $since = $_GET['since'];
        $until = $_GET['until'];

        if(strtoupper($requestMethod) == 'GET')
        {
            try
            {
                $vesselModel = new Vessel();

                $arrVessel = $vesselModel->getVesselFromTime($since, $until);
                $responseData = json_encode($arrVessel);
            }
            catch(Error $e)
            {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        }
        else
        {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
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
    
}
?>