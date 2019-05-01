<?php
session_start();
if(!isset($_SESSION['INDEX'])){
	$_SESSION['INDEX']=true;
}

if(isset($_GET['prn'])&&isset($_GET['subject'])){
	$_SESSION['prn'] = $_GET['prn'];
	$_SESSION['subject'] = $_GET['subject'];
	include_once "./MongoDB.php";
	$obj = new MDB();
	$_SESSION['QUESTIONS'] = $obj->getQuestionList($_GET['subject']);
	$_SESSION['TIMER'] = $obj->getTimer($_GET['subject']);
	$_SESSION['WARNING'] = 3;
	$_SESSION['QUESTION_NUMBER']=0;
	if(!file_exists('./TESTS/'.$_GET['subject']."/".$_GET['prn'])){
		$handle = fopen('./TESTS/'.$_GET['subject']."/".$_GET['prn'],'a');
		foreach($_SESSION['QUESTIONS'] as $doc){
			fwrite($handle,"0\n");
		}
	}
	if(!file_exists('./TESTS/'.$_GET['subject']."/".$_GET['prn']."_time")){
		$handle = fopen('./TESTS/'.$_GET['subject']."/".$_GET['prn']."_time",'a');
		fwrite($handle,$_SESSION['TIMER']);
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
	<link rel="stylesheet" href="./css/bootstrap.min.css">
	<link rel="stylesheet" href="./css/jquery-ui.min.css">
	<script src="./js/popper.min.js"></script>
	<script src="./js/jquery.min.js"></script>
	<script src="./js/jquery-ui.min.js"></script>
	<script src="./js/loadingoverlay.min.js"></script>
	<script src="./js/bootstrap.min.js"></script>



<style>

body, html {
height: 100%;
background-repeat: no-repeat;
background-image:url('./img/back.jpg');
background-position: center;
background-size: cover;
position: relative; 
color:black;
overflow:hidden;
}

</style>

</head>
<body oncontextmenu="return false;">
<div class="container">
<center>
    <div class="form-horizontal" style="margin-top:20vh;padding-bottom:20px;background-color:white;width:60vw;" action="#" align="center">
		<br/><br/><center>
		<div class="col-sm-6 col-sm-offset-3">
		<div class="panel panel-default">
		<div class="panel-body">
		<div>
		<h2>MOCK TEST</h2>
		<h3>Number of Questions: 
		<?php
			echo count($_SESSION['QUESTIONS']);
		?>
		</h3>	
		<h3>Time: <?php
			$opt = file('./TESTS/'.$_SESSION['subject'].'/'.$_SESSION['prn'].'_time');
			$time = intval($opt[0]);
			$hr = intval($time/3600);
			$time = intval($time%3600);
			$min = intval($time/60);
			$time = intval($time%60);
			$sec = $time;
			if($hr>0){
				echo "Hr:-".intval($hr).":";
			}
			echo "Min:-".intval($min).":Sec:-".$sec;
		?></h3>
		<button style="font-size:4vh" class="btn btn-primary" type="submit" onclick="start()"><i>Start</i></button>
		</div>
		</div>
		</div>
		</div></center>
</div>
	</center>	
</div>
</body>
<script>
	function start(){
		window.location.href="mcq.php";
	}
$(document).keydown(function(e){
		return false;
});
history.pushState(null, null, document.url);
window.addEventListener('popstate', function () {
    window.location="./last.php";
});
</script>

</html>
