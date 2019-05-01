<?php
if(session_status()==1){
    session_start();
}
$qno = $_GET['number'];

$obj = $_SESSION['QUESTIONS'][$qno];

echo json_encode(array('QUESTION'=>$obj['QUESTION'],'OPTION1'=>$obj['OPTION1'],'OPTION2'=>$obj['OPTION2'],'OPTION3'=>$obj['OPTION3'],'OPTION4'=>$obj['OPTION4']));

?>
