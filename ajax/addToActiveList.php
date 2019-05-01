<?php

if(session_status()==1){
    session_start();
}

$name = $_SESSION['NAME'];
$sub = $_GET['subject'];
$t = $_GET['time'];

include_once "../MongoDB.php";

$obj = new MDB();

$id = $obj->setTest($sub,$name,$t);

if($id=="FASLE"){
    echo "FALSE";
}else{
    if(!is_dir('../TESTS/'.$id)){
        mkdir('../TESTS/'.$id);
    }
    echo $id;
}

?>