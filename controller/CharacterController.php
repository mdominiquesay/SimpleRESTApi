<?php
include 'model/CharacterModel.php';
class CharacterController 
{
    private $conn;
    private $responseController;
    
    function __construct() {
        $dbController=new Database();
        $this->conn=$dbController->getConnection();
        $this->responseController=new ResponseController();
    }
    function validateInput($request)
    {
        $character= new CharacterModel();
        $firstname=$this->validate_input($request,'first_name',50);
        $lastname=$this->validate_input($request,'last_name',50);
        $character->setFirst_Name($firstname);
        $character->setLast_name($lastname);
        return $character;
    }
    function getCharacter($character)
    {
        $first_name=$character->getFirst_name();
        $Last_name=$character->getLast_name();
        $select="Select * from  character_list where first_name=? and  last_name=? limit 1";
        if($stmt = $this->conn->prepare($select))
        {
            $stmt->bind_param("ss",$first_name, $Last_name);
            $stmt->execute();
            $result = $stmt->get_result();
            if(($row=$result->fetch_assoc()))
            {
 
                $character->setID($row["id"]);
                $character->setDelete_Ind($row["delete_ind"]);
            }
            else{$character=null;}
        }
        return $character;
    }
    function getCharacterBYID($character)
    {
        $id=$character->getID();
        $select="Select * from  character_list where id=? limit 1";
        if($stmt = $this->conn->prepare($select))
        {
            $stmt->bind_param("i",$id);
            $stmt->execute();
            $result = $stmt->get_result();
            if(($row=$result->fetch_assoc()))
            {
                $character->setFirst_name($row["first_name"]);
                $character->setLast_name($row["last_name"]);
                $character->setID($row["id"]);
                $character->setDelete_Ind($row["delete_ind"]);
            }
            else{$character=null;}
        }
        return $character;
    }
    function createCharacter($character)
    {
        $first_name=$character->getFirst_name();
        $Last_name=$character->getLast_name();
        $var=true;
        $character=$this->getCharacter($character);
        if($character){
            if(!$character->getDelete_Ind())
            {
                $character->setDelete_Ind(1);
                $this->activateDeleteInd($character);
                $this->responseController->getResponse("Character Created");
            }else
            {
                $this->responseController->getError(100);
                die();
            }
            $var=false;
        }
        if($var)
        {
            // prepare sql and bind parameters
            $insert="INSERT INTO character_list (first_name, last_name) VALUES (?, ?)";
            if($stmt = $this->conn->prepare($insert))
            {
                $stmt->bind_param("ss",$first_name, $Last_name);
                $stmt->execute();
                $this->responseController->getResponse("Character Added");
            
            }else{
                $this->responseController->getError(200);
                die();
            }
        }
    }
    function validate_input($request,$value,$length=false) {
        $data='';
        if(isset($request[$value]))
        {
            $data=$request[$value];
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            if($length && strlen($data)>$length)
            {
                $this->responseController->getError(300);
                die();
            }
        }
        return $data;
    }
    function activateDeleteInd($character)
    {
        $select="Update character_list set delete_ind='".$character->getDelete_Ind()."'  where id='".$character->getID()."' limit 1";
        if ($this->conn->query($select)) 
            $this->responseController->getResponse("Character Updated");
        else 
            $this->responseController->getError(500);
    }
    function updateCharacter($character)
    {
        $old_character=$this->getCharacterBYID($character);
        $exist_character=$this->getCharacter($character);
        if(!$exist_character){
            if($exist_character->getID()==$character->getID())
            {
                $character->setDelete_Ind(1);
                $this->activateDeleteInd($character);
                $this->responseController->getResponse("Character Updated");
            }
        }
        elseif($old_character){
            $select="Update character_list set delete_ind=?,
            first_name=?,
            last_name=?
            where id=? limit 1";
            if($stmt = $this->conn->prepare($select))
            {
                $delete_ind=$character->getDelete_Ind();
                $first_name=$character->getFirst_name();
                $last_name=$character->getLast_name();
                $id=$character->getID();
                $stmt->bind_param("issi",$delete_ind,$first_name, $last_name,$id);
                $stmt->execute();
                $this->responseController->getResponse("Character Updated");
                
            }else{
                $this->responseController->getError(500);
                die();
            }
        }
        else
        {
            $this->responseController->getError(200);
            die();
        }
    }
    function deleteCharacter($id)
    {
        $character = new CharacterModel();
        $character->setID($id);
        $character=$this->getCharacterBYID($character);
        if($character)
        {
            $character->setDelete_Ind(0);
            $this->activateDeleteInd($character);
            $this->responseController->getResponse("Character Deleted");
        }
        else 
            $this->responseController->getError(100);
            
    }
    function getCharacterRead($id)
    {
        $character = new CharacterModel();
        $character->setID($id);
        $character=$this->getCharacterBYID($character);
        if($character)
            $this->responseController->getResponse("Character  ".$character->getFirst_name());
        else
            $this->responseController->getError(200);
    }
    function getCharacters($sort='',$limit='')
    {
        //sort
        //limit 
        $response=array();
        $select="Select * from  character_list ";
        if($sort)
            $select=$select." ORDER BY ".$sort;
        if($limit)
            $select=$select." LIMIT  ".$limit;
        ECHO $select;
        $result = $this->conn->query($select);
        if ($result->num_rows > 0) {
            {
                while($row = $result->fetch_assoc()) {
                    $character = new CharacterModel();
                    $character->setFirst_name($row["first_name"]);
                    $character->setLast_name($row["last_name"]);
                    $character->setID($row["id"]);
                    $character->setDelete_Ind($row["delete_ind"]);
                    array_push($response,
                    array(
                        'first_name'=>$character->getFirst_name(),
                        'last_name'=>$character->getLast_name(),
                        'id'=>$character->getID(),
                        'delete_ind'=>$character->getDelete_Ind()
                    ));
                }
            } 
            $this->responseController->getResponse($response);  
        }
    }
}