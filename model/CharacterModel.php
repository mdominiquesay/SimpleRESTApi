<?php
class CharacterModel
{
    private $first_name;
    private $last_name;
    private $delete_ind=false;
    private $id;
    function setFirst_Name($first_name){ $this->first_name=$first_name;}
    function setLast_name($last_name){ $this->last_name=$last_name;}

    function getFirst_Name(){ return $this->first_name;}
    function getLast_name(){ return $this->last_name;}

    function setDelete_Ind($delete_ind){ $this->delete_ind=($delete_ind===1); }
    function getDelete_Ind(){ return $this->delete_ind;}

    function setID($ID){ $this->ID=$ID;}
    function getID(){ return $this->ID;}
}
?>