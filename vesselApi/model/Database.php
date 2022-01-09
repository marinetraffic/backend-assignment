<?php
class Database{
    
    protected  $conn = null;
    
    // get the Database connection
    public function __construct(){
        
        $this->conn = null;
        
        try {
            $this->conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);
            
            if ( mysqli_connect_errno()) {
                throw new Exception("Could not connect to Database.");
            }
        } catch (Exception $e) {
            echo "Connection error: " . $e->getMessage();
            throw new Exception($e->getMessage());
        }			
              
        
    }
    
    public function __destruct()
    {
        mysqli_close($this->conn);
    }
    
    public function select($query = "" , $params = [])
    {
        try {
            $stmt = $this->executeStatement( $query , $params );
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            
            return $result;
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }
        return false;
    }
    
    public function insert($query = "")
    {
        try {
            $stmt = $this->executeStatement( $query );
            $stmt->close();
            return true;
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }
        return false;
    }
    
    private function executeStatement($query = "" , $params = [])
    {
        try {
            $stmt = $this->conn->prepare( $query );
            
            if($stmt === false) {
                throw New Exception("Unable to do prepared statement: " . $query);
            }
            
            if( $params ) {
                $stmt->bind_param($params[0], $params[1]);
            }
            
            $stmt->execute();
            
            return $stmt;
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }
    }
}
?>