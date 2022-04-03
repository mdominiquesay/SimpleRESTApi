<?php
include 'connect.php';
include 'controller/APIController.php';
include 'controller/CharacterController.php';
include 'controller/ResponseController.php';

function getApiData($request_uri,$request)
{
    $router= str_ireplace('/SimpleRESTAPI','',$request_uri);
    $data=explode("?",$router,2);
    $list=array("/read","/create","/update","/delete");
    if(in_array($data[0],$list))
    {
        $characterController = new CharacterController();
        $controller = new ApiController;
        if($controller->checkAPI())
        {
            switch ($data[0]) {
                case "/create":
                    $character=$characterController->validateInput($request);
                    $characterController->createCharacter($character);
                break;
                case "/read":
                    $id=$characterController->validate_input($request,'id');
                    if($id)
                        $characterController->getCharacterRead($id);
                    else
                    {
                        $sort=$characterController->validate_input($request,'sort');
                        $limit=$characterController->validate_input($request,'limit');
                         $characterController->getCharacters($sort,$limit);
                    }
                        break;
                case "/update":
                    $character=$characterController->validateInput($request);
                    $id=$characterController->validate_input($request,'id');
                    if($id){
                    $character->setID($id);
                    $characterController->updateCharacter($character);
                    }
                    break;
                case "/delete":
                    $id=$characterController->validate_input($request,'id');
                    if($id)
                        $characterController->deleteCharacter($id);
                    echo "<br>".$id;
                    break;
                }
        }
    }
    else
    {
        if(str_replace("/","",$data[0])==="test")
            include 'test/index.php';
        else
        {
            $responseController=new ResponseController();
            $responseController->getError(900);
        }    
    }
}

?>