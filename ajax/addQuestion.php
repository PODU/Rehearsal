<?php

$id = $_GET['ID'];
$question = $_GET['QUESTION'];
$option1 = $_GET['OPTION1'];
$option2 = $_GET['OPTION2'];
$option3 = $_GET['OPTION3'];
$option4 = $_GET['OPTION4'];
$answer = $_GET['ANSWER'];
$co = $_GET['CO'];
$type = $_GET['TYPE'];

function validAns($a){
    if(strlen($a)!=1){
        return false;
    }else{
        if($a=='1'||$a=='2'||$a=='3'||$a=='4'){
            return true;
        }else{
            return false;
        }
    }
}

include_once "../MongoDB.php";

$obj = new MDB();

if(validAns($answer)){
    echo $obj->addQuestion(str_replace(" \n","",$id),str_replace("\n","<br/>",htmlspecialchars($question)),str_replace("\n","<br/>",htmlspecialchars($option1)),str_replace("\n","<br/>",htmlspecialchars($option2)),str_replace("\n","<br/>",htmlspecialchars($option3)),str_replace("\n","<br/>",htmlspecialchars($option4)),$answer,$co,$type);
}else{
    echo "ZZZ";
}

?>