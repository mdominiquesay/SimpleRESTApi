<?php
class Database{

    public $db;
    private function connect(){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "simple_REST_API_files";
        $this->db= null;
        try{
            $this->db =new mysqli($servername, $username, $password, $dbname);
        }catch(Exception $e)
        {
            echo "Database could not connect".$e->getMessage();
        }
    }

    public function getConnection()
    {
        if(!$this->db)
        {
            $this->connect();
        }
        return $this->db;
    }
}

?>