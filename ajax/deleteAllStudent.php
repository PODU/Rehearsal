<?php

$test = $_GET['testID'];
include_once '../MongoDB.php';
$obj = new MDB();
$conn = new MongoClient();
$connection = $conn->COLLEGE->studentLogin;
$res = $connection->find(array('TEST'=>$test));
foreach($res as $r){
	$obj->deleteStudent($r['_id']);
}

?>