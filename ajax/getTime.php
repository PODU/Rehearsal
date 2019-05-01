<?php
if(session_status()==1){
    session_start();
}
$test = $_SESSION['subject'];
$prn = $_SESSION['prn'];
$text = file_get_contents('../TESTS/'.$test.'/'.$prn."_time");
$text = $text-1;
echo $text;
$handle =  fopen('../TESTS/'.$test.'/'.$prn.'_time','w');
fwrite($handle,$text);
?>



