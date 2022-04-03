<?php 
class ResponseController 
{
    function getError($error_code) {
        $errorDetail=array(
            410=>"The API no longer supports requests that do not pass in a version parameter."
            ,100=>"Character name already exits"
            ,200=>"Character does not exits",
            900=>'Unknown URL'
        );
        $error=array(
            "meta"=>array(
                "code"=>"",   
                "errorDetail"=>""
            ),
            'response'=>array()
        );
        $error_details="";
        if($errorDetail[$error_code])
        {
            $error['meta']['errorDetail']=$errorDetail[$error_code];
        } 
        echo json_encode($error);
    }
    function getResponse($response)
    {
        $response_arr=array(
            'response'=>array($response)
        );
        echo json_encode($response_arr);
    }
}
?>