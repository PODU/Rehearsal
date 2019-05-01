<?php

include_once "../MongoDB.php";

$u = $_GET['username'];
$p = $_GET['password'];
$est = $_GET['test'];
$obj = new MDB();
$res = $obj->getStudentAuth($u,$p);

if(session_status()==1){
    session_start();
}

if($res=="FALSE"){
    echo "FALSE";
}else{
    $ans = $obj->checkLogin($test,$prn);
    if($ans=="FALSE"){
        echo "FALSE";
    }else{
        $_SESSION['NAME'] = $res;
        echo "TRUE";
    }
}
?>
