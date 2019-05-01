<?php
if(session_status()==1){
    session_start();
}
$qno = $_GET['qno'];
$val = $_GET['val'];
$ip = file('../TESTS/'.$_SESSION['subject'].'/'.$_SESSION['prn']);
$ip[$qno]=$val."\n";
$text = $ip[0];
for($i=1;$i<count($ip);$i++){
    $text = $text.$ip[$i];
}
$handle =  fopen('../TESTS/'.$_SESSION['subject'].'/'.$_SESSION['prn'],'w');
fwrite($handle,$text);
echo "DONE";
?>