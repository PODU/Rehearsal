<?php
$v=false;
if(isset($_GET['prn'])&&isset($_GET['password'])){
	include_once "../MongoDB.php";
	$obj = new MDB();
	$res = $obj->getTeacherAuth($_GET['prn'],$_GET['password']);
	if($res=="TRUE"){
		session_start();
		$_SESSION['NAME']=$_GET['prn'];
		header('Location:./teacherMain.php');
	}else{
		$v=true;
	}
}
?>

<html><head>
	<title>Registration</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/jquery-ui.min.css">
	<script src="../js/popper.min.js"></script>
	<script src="../js/jquery.min.js"></script>
	<script src="../js/jquery-ui.min.js"></script>
	<script src="../js/loadingoverlay.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>

	<style>
		body,
		html {
			height: 100%;
			background-repeat: no-repeat;
			background-color:gray;
			background-position: center;
			background-size: cover;
			position: relative;
			color: black;
		}
	</style>
</head>

<body>
	<div oncontextmenu="return false;" style="overflow:hidden;" class="container">
		<center>
			<form name="drform" style="background-color:white;margin-top:20vh;width:50vw;padding-bottom: 10px;box-shadow:0 10px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19) !important;" class="form-horizontal" method="GET" action="index.php">
				<br><br>
				<div>
					<h2>
						<center><i>Teachers Login</i></center>
					</h2>
				</div>
				<div class="form-group">
						<div class="com-sm-10">
							<input class="form-control" style="width:40vw;" name="prn" id="prn" placeholder="Enter Your Name." type="text">
						</div>
				</div>
				<div class="form-group">
						<div class="com-sm-10">
							<input class="form-control" style="width:40vw;" name="password" id="password" placeholder="Enter Password." type="password">
						</div>
				</div>
				<div class="form-group">
						<div class="com-sm-10">
								<div class="input-group mb-3" style="width: 500px;">
										<div class="input-group-prepend">
										  
										</div>
										
									  </div>									  
						</div>
				</div>
				<div class="form-group">
						<div style="color:red;" id="WARNING" class="com-sm-10">
							<?php if($v){echo "LogIn is Wrong";}?>
						</div>
				</div>
				<div class="form-group">
						<div class="com-sm-10">
							<button type="submit" class="btn btn-primary">Submit</button>
						</div>
				</div>
				<div class="form-group">
						<div class="com-sm-10">
							<a href="./signup.php">New User?</a>
						</div>
				</div>
			</form>
		</center>
	</div>

</body></html>
