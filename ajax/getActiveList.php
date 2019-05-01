<?php

include_once "../MongoDB.php";

if(session_status()==1){
    session_start();
}


$obj = new MDB();

$res = $obj->getActiveList();
$ans = array();
foreach($res as $doc){
    if($doc['BY']==$_SESSION['NAME']){
        array_push($ans,$doc['SUBJECT'].'#####'.$doc['ID']);
    }
}

echo json_encode($ans);

?>