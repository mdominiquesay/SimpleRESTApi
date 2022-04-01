<?php
class Database{

    public $db;
    public function getConnection(){
        $this->db= null;
        try{
            $this->db =new mysqli('localhost','root','',$db_name);
        }catch(Exception $e)
        {
            echo "Database could not connect".$e->getMessage();
        }
        return $db;
    }
}

?>