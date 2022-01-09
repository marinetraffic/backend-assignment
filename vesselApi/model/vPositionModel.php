<?php
require_once PROJECT_ROOT_PATH . "model/Database.php";

class vPositionModel extends Database
{
    public function getAllPositions($limit)
    {
        return $this->select("SELECT * FROM vesselPosition ORDER BY timestamp ASC LIMIT ". $limit);
    }
    
    public function getPositions($mmsiArray, $lon_min,$lon_max,$lat_min,$lat_max,$time_min,$time_max)
    {
        $queryTotal='SELECT * FROM vesselPosition';
        $query='';
        
        $manyFilters=false;
        foreach ($mmsiArray as $mmsi)
        {
        	if($manyFilters==true){
        		$query.=' OR';
        	}
        	if($mmsi!=null)
        	{
            	$query.=' mmsi='.$mmsi;
            	$manyFilters=true;        
        	}
        }
        if($lon_min!=null)
        {
        	if($manyFilters==true){
        		$query.=' AND';
        	}
            $query.=" lon>=".$lon_min;
            $manyFilters=true;              
        }
        if($lon_max!=null)
        {
        	if($manyFilters==true){
        		$query.=' AND';
        	}
            $query.=" lon<=".$lon_max;
            $manyFilters=true;
        }
        if($lat_min!=null)
        {
        	if($manyFilters==true){
        		$query.=' AND';
        	}
            $query.=" lat>=".$lat_min;
            $manyFilters=true;
        }
        if($lat_max!=null)
        {
        	if($manyFilters==true){
        		$query.=' AND';
        	}
            $query.=" lat<=".$lat_max;
            $manyFilters=true;
        }
        if($time_min!=null)
        {
        	if($manyFilters==true){
        		$query.=' AND';
        	}
            $query.=" timestamp>=".$time_min;
            $manyFilters=true;
        }
    	if($time_max!=null)
        {
        	if($manyFilters==true){
        		$query.=' AND';
        	}
        	$query.=" timestamp<=".$time_max;
            $manyFilters=true;
        }	
        if($query!=null)
        {
            $queryTotal.=" where". $query;
        }
        $queryTotal.=" ORDER BY timestamp ASC";
              
        return $this->select($queryTotal);
    }
    
    public function addPositions($decodedjson)
    {
        $addedPositions ='';
      
        foreach($decodedjson as $row) {
            
            // Database query to insert data
            // into database Make Multiple
            // Insert Query
            
            $query = "INSERT INTO vesselPosition VALUES
            ('".$row["mmsi"]."', '".$row["status"]."',
                '".$row["stationId"]."', '".$row["speed"]."',
                '".$row["lon"]."', '".$row["lat"]."',
                '".$row["course"]."', '".$row["heading"]."',
                '".$row["rot"]."', '".$row["timestamp"]."' )";
            
            $addedPositions.= $this->insert($query);
        }
        
        return  $addedPositions;
    }
}

?>