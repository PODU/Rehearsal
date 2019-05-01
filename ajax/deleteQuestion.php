<?php

$id = $_GET['id'];

include_once '../MongoDB.php';

$obj = new MDB();

echo $obj->deleteQuestion($id);

?>