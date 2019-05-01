<?php

$id = $_GET['ID'];
$conn = new MongoClient();
if ($conn == null) {
    die("CONNECTION ERROR");
}
$collection = $conn->COLLEGE->activeList;
$content = array('_id' => new MongoId($id));
$collection->remove($content,array('justOne'=>true));
        
?>