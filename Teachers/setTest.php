<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MCQ System</title>
</head>
<body>
    
<?php

include_once "../MongoDB.php";
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

function validAns($a){
    if(strlen($a)!=1){
        return false;
    }else{
        if($a=='1'||$a=='2'||$a=='3'||$a=='4'){
            return true;
        }else{
            return false;
        }
    }
}

function validPRN($rno){
    return preg_match("/^[a-zA-Z]{1}[0-9]+$/",$rno);
}

function validUsername($n){
    return preg_match("/^[a-zA-Z ]+$/",$n);;
}

if(session_status()==1){
    session_start();
}

$name = $_SESSION['NAME'];

if(isset($_POST['SUBJECTNAME'])&&isset($_POST['DESCRIPTION'])&&isset($_POST['TIMER'])){
    if(!empty($_POST['SUBJECTNAME'])&&!empty($_POST['DESCRIPTION'])&&!empty($_POST['TIMER'])){
        $obj = new MDB();
        $id = $obj->setTest($_POST['SUBJECTNAME']."(".$_POST['DESCRIPTION'].")",$name,$_POST['TIMER']);
        if($id=="FASLE"){
            echo "Adding Test Failed";
        }else{
            if(!is_dir('../TESTS/'.$id)){
                mkdir('../TESTS/'.$id);
            }
            if($_FILES['STUDENTLIST']['error']!=0||$_FILES['STUDENTLIST']['error']!=4){
                $target_dir = "./upload/";
                $target_file = $target_dir . basename($_FILES['STUDENTLIST']["name"]);
                $uploadOk = 1;
                if (move_uploaded_file($_FILES["STUDENTLIST"]["tmp_name"], $target_file)) {
                    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
                    $reader->setReadDataOnly(TRUE);
                    $spreadsheet = $reader->load($target_file);
                    $worksheet = $spreadsheet->getActiveSheet();
                    $highestRow = $worksheet->getHighestRow();
                    $passes = array();
                    for($i=2;$i<=$highestRow;$i+=1){
                        $prn = $worksheet->getCellByColumnAndRow(2, $i)->getValue();
                        $name = $worksheet->getCellByColumnAndRow(3, $i)->getValue();
                        $pass = rand(100000,999999);
                        while(in_array($pass,$passes)){
                            $pass = rand(100000,999999);
                        }
                        array_push($passes,$pass);
                        if(validPRN($prn)&&validUsername($name)){
                            $obj->addStudent(str_replace(" \n","",$id),$name,$prn,$pass);
                        }else{
                            echo "<div style='border:3px solid black;'>";
                            echo "<form method='GET' action='' onsubmit='return false;'>";
                            echo "<button style='float:right;'onclick='delBlock(this)'>Discard this Block</button>";
                            echo "<h5 style='color:red'>Enter Valid Details</h5>";
                            echo "<label>PRN<input type='text' value='".$prn."'></label><br>";
                            echo "<label>Name<input type='text' value='".$name."'></label><br>";
                            echo "<label><input type='hidden' value='".$id."'></label><br>";
                            echo "<label><input type='hidden' value='".$pass."'></label><br>";
                            echo "<button type='submit' onclick='adddata(this);'>Submit this Block</button>";
                            echo "</form>";
                            echo "</div>";
                        }
                    }
                    unlink($target_file);
                } else {
                    echo "Sorry, there was an error uploading your Student List File file.";
                }
            }else{
                echo "Student List Not Selected";
            }
            if(count($_FILES['QUESTIONLIST'])>0){
                $target_dir = "./upload/";
                $target_file = $target_dir . basename($_FILES["QUESTIONLIST"]["name"]);
                $uploadOk = 1;
                if (move_uploaded_file($_FILES["QUESTIONLIST"]["tmp_name"], $target_file)) {
                    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
                    $reader->setReadDataOnly(TRUE);
                    $spreadsheet = $reader->load($target_file);
                    $worksheet = $spreadsheet->getActiveSheet();
                    $highestRow = $worksheet->getHighestRow();
                    for($i=2;$i<=$highestRow;$i+=1){
                        $question = $worksheet->getCellByColumnAndRow(2, $i)->getValue();
                        $op1 = $worksheet->getCellByColumnAndRow(3, $i)->getValue();
                        $op2 = $worksheet->getCellByColumnAndRow(4, $i)->getValue();
                        $op3 = $worksheet->getCellByColumnAndRow(5, $i)->getValue();
                        $op4 = $worksheet->getCellByColumnAndRow(6, $i)->getValue();
                        $ans = $worksheet->getCellByColumnAndRow(7, $i)->getValue();
                        $co = $worksheet->getCellByColumnAndRow(8, $i)->getValue();
                        $type = $worksheet->getCellByColumnAndRow(9, $i)->getValue();
                        if(validAns($ans)){
                            $obj->addQuestion(str_replace(" \n","",$id),str_replace("\n","<br/>",htmlspecialchars($question)),str_replace("\n","<br/>",htmlspecialchars($op1)),str_replace("\n","<br/>",htmlspecialchars($op2)),str_replace("\n","<br/>",htmlspecialchars($op3)),str_replace("\n","<br/>",htmlspecialchars($op4)),$ans,$co,$type);
                        }else{
                            echo "<div style='border:3px solid black;'>";
                            echo "<form method='GET' action='' onsubmit='return false;'>";
                            echo "<button style='float:right;'onclick='delBlock(this)'>Discard this Block</button>";
                            echo "<h5 style='color:red'>Enter Valid Details</h5>";
                            echo "<label>Question<input type='text' value='".$question."'></label><br>";
                            echo "<label>Option1<input type='text' value='".$op1."'></label><br>";
                            echo "<label>Option2<input type='text' value='".$op2."'></label><br>";
                            echo "<label>Option3<input type='text' value='".$op3."'></label><br>";
                            echo "<label>Option4<input type='text' value='".$op4."'></label><br>";
                            echo "<label>Answer<input type='text' value='".$ans."'></label><br>";
                            echo "<label><input type='hidden' value='".$co."'></label><br>";
                            echo "<label><input type='hidden' value='".$type."'></label><br>";
                            echo "<label><input type='hidden' value='".$id."'></label><br>";
                            echo "<button type='submit' onclick='adddata1(this);'>Submit this Block</button>";
                            echo "</form>";
                            echo "</div>";
                        }
                    }
                    unlink($target_file);
                } else {
                    echo "Sorry, there was an error uploading your Student List File file.";
                }
            }else{
                echo "Student List Not Selected";
            }

        }
    }else{
        echo "Subject Name/Description/Timer is Empty";
    }
}else{
    echo "All Values are not Set";
}
?>


<center><button onclick="history.back()"><h3>ALL DONE</h3></button></center>
</body>
<script src="../js/jquery.min.js"></script>
<script>
function delBlock(q){
    var a = q.parentElement;
    a.innerHTML="";
}
function adddata(asd){
    var a = asd.parentElement;
    var prn = a.elements[0].value;
    var name = a.elements[1].value;
    var id = a.elements[2].value;
    var pass = a.elements[3].value;
    $.ajax({
        url:'../ajax/addStudent.php',
        type:'GET',
        data:{'ID':id,'PRN':prn,'NAME':name,'PASS':pass},
        success: function(res){
            if(res=="TRUE"){
                delBlock(asd);
            }else{
                alert("Enter Valid PRN and Name");
            }
        }

    });
}
function adddata1(asd){
    var a = asd.parentElement;
    var question = a.elements[0].value;
    var op1 = a.elements[1].value;
    var op2 = a.elements[2].value;
    var op3 = a.elements[3].value;
    var op4 = a.elements[4].value;
    var ans = a.elements[5].value;
    var co = a.elements[6].value;
    var type = a.elements[7].value;
    var id = a.elements[8].value;
    $.ajax({
        url:'../ajax/addQuestion.php',
        type:'GET',
        data:{'ID':id,'QUESTION':question,'OPTION1':op1,'OPTION2':op2,'OPTION3':op3,'OPTION4':op4,'ANSWER':ans, 'CO':co, 'TYPE':type},
        success: function(res){
            if(res=="TRUE"){
                delBlock(asd);
            }else{
                alert("Answer must be 1/2/3/4");
            }
        }
    });
}
</script>
</html>
