<?php
class BaseController
{
    /**
     * __call magic method.
     */
    public function __call($name, $arguments)
    {
        $this->sendOutput('', array('HTTP/1.1 404 Not Found'));
    }
    
    /**
     * Get URI elements.
     *
     * @return array
     */
    protected function getUriSegments()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode( '/', $uri );
        
        return $uri;
    }
    
    /**
     * Get querystring params.
     *
     * @return array
     */
    protected function getQueryStringParams()
    {
        return parse_str($_SERVER['QUERY_STRING'], $query);
    }
    
    /**
     * Send API output.
     *
     * @param mixed  $data
     * @param string $httpHeader
     */
    protected function sendOutput($data, $httpHeaders=array())
    {
        header_remove('Set-Cookie');
        
        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }
        
        echo $data;
        exit;
    }
    
    
    protected function downloadOutput($data, $httpHeaders=array())
    {
        header_remove('Set-Cookie');
        
        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }
        
        $output = fopen("php://output", "wb");
        foreach ($data as $row)
            fputcsv($output, $row); // here we can change delimiter/enclosure
        fclose($output);
        
        echo $data;
        exit;
    }
    
    function download_csv_results($results, $name = NULL)
	{
	    if( ! $name)
	    {
	        $name = md5(uniqid() . microtime(TRUE) . mt_rand()). '.csv';
	    }
	
	    header('Content-Type: text/csv');
	    header('Pragma: no-cache');
	    header('Content-Disposition: attachment; filename='. $name);
	    header("Expires: 0");
	
	    $outstream = fopen("php://output", "wb");
	
	    foreach($results as $result)
	    {
	        fputcsv($outstream, $result);
	    }
	
	    fclose($outstream);
	}
}
?>