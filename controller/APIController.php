<?php
class ApiController 
{
    private $conn;
    function __construct() {
        $dbController=new Database();
        $this->conn=$dbController->getConnection();
    }
    public function checkAPI()
    {   
        if(!isset($_REQUEST['api_key']))
        {
            $responseController=new ResponseController();
            $responseController->getError(410);
            die();
        }
        $api_key=$_REQUEST['api_key'];
        $stmt = $this->conn->prepare("SELECT * FROM api_key_file where api_key=?");
        $stmt->bind_param("s",$api_key);
        $stmt->execute();
        $result = $stmt->get_result();
        $var=true;
        if(!($result->fetch_assoc()))
        {
            $responseController=new ResponseController();
            $responseController->getError(410);
            $var=false;
        }
        
        return $var;
    }
    
}
?>