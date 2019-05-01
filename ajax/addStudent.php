<?php

$id = $_GET['ID'];
$name = $_GET['NAME'];
$prn = $_GET['PRN'];
$pass = $_GET['PASS'];

include_once "../MongoDB.php";

$obj = new MDB();

function validPRN($rno){
    return preg_match("/^[a-zA-Z]{1}[0-9]+$/",$rno);
}

function validUsername($name){
    return preg_match("/^[a-zA-Z ]+$/",$name);
}

if(validPRN($prn)&&validUsername($name)){
    echo $obj->addStudent(str_replace(" \n","",$id),$name,$prn,$pass);
}else{
    echo "ZZZ";
}

?>