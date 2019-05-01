<?php
if(session_status()==1){
session_start();
}
$num = $_GET['qno'];
$test = $_SESSION['subject'];
$prn = $_SESSION['prn'];
$file = file('../TESTS/'.$test.'/'.$prn);
echo $file[$num];
?>
