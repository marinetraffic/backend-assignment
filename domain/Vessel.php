<?php
require_once PROJECT_ROOT_PATH . "/utils/Database.php";
class Vessel extends Database
{
  public function getVessels()
  {
    return $this->select("SELECT mmsi, status, stationid, speed, lon, lat, course, heading, rot, timestamp FROM vessels");

  }
  public function getVessel($mmsi)
  {
    return $this->select("SELECT mmsi, status, stationid, speed, lon, lat, course, heading, rot, timestamp FROM vessels WHERE mmsi=$mmsi");
  }
  public function getVesselFromLatAndLong($latFrom, $latTo, $longFrom, $longTo)
  {
    return $this->select("SELECT mmsi, status, stationid, speed, lon, lat, course, heading, rot, timestamp FROM vessels WHERE lat >= $latFrom AND lat <= $latTo AND lon >= $longFrom AND lon <= $longTo");
  }
  public function getVesselFromTime($timeFrom, $timeTo)
  {
    return $this->select("SELECT mmsi, status, stationid, speed, lon, lat, course, heading, rot, timestamp FROM vessels WHERE timestamp >= $timeFrom AND timestamp <= $timeTo");
  }
}
?>