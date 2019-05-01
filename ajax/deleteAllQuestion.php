<?php

$test = $_GET['testID'];
include_once '../MongoDB.php';
$obj = new MDB();
$conn = new MongoClient();
$connection = $conn->COLLEGE->questionList;
$res = $connection->find(array('TEST'=>$test));
foreach($res as $r){
	$obj->deleteQuestion($r['_id']);
}

?>