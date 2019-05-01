<?php
$v=false;
$bool=false;
if(isset($_GET['name'])&&isset($_GET['password'])){
		include_once "../MongoDB.php";
		$obj = new MDB();
		$check = $obj->checkUserName(trim($_GET['name']));
		if($check=="TRUE"){
			$obj->registerTeacher(trim($_GET['name']),trim($_GET['password']));
			header("Location:./index.php");
		}else{
			$bool=true;
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
			background-position: center;
			background-color:gray;
			background-size: cover;
			position: relative;
			color: black;
		}
	</style>
</head>

<body>
	<div oncontextmenu="return false;" style="overflow:hidden;" class="container">
		<center>
			<form name="drform" style="box-shadow:0 10px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19) !important;background-color:white;margin-top:20vh;width:50vw;padding-bottom: 10px;" class="form-horizontal" method="GET" action="./signup.php" onsubmit="return Validate()">
				<br><br>
				<div>
					<h2>
						<center><i>MESCOE</i></center>
					</h2>
				</div>
				<?php
					if($bool){
						echo "<div><center><h4 style=\"color:red;\">Username already Exist</h4></center></div>";
					}
				?>
				<div class="form-group">
						<div class="com-sm-10">
							<input class="form-control" style="width:40vw;" name="name" id="name" placeholder="Enter Your Name." required type="text">
						</div>
				</div>

				<div class="form-group">
						<div class="com-sm-10">
							<input class="form-control" style="width:40vw;" name="password" id="password" placeholder="Enter Password." required type="password">
						</div>
				</div>

				<div class="form-group">
						<div class="com-sm-10">
							<input class="form-control" style="width:40vw;" name="conf_password" id="conf_password" placeholder="Confirm Password." required type="password">
						</div>
				</div>
				<div class="form-group">
						<div class="com-sm-10">
							<button type="submit" class="btn btn-primary">Submit</button>
						</div>
				</div>
				<div class="form-group">
					<div class="com-sm-10">
						<a href="./">Log IN</a>
					</div>
				</div>
			</form>
		</center>
	</div>
	<script>
		function Validate() {
			var v1 = $('#conf_password').val(),v2=$('#password').val();
			if(v1==v2){
			}
			else{
				alert("Your Password and Confirm Password Does Not Match");
				return false;
			}
			return true;
		}
	</script>


</body></html>
