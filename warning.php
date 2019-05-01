<html>
<head>
	<title>Warning</title>
	<link rel="stylesheet" href="./css/bootstrap.min.js">
	<script src="./js/bootstrap.min.js"></script>
	<script src="./js/jquery.min.js"></script>
	  
  <script>
  	function redirect(){
  		window.location.href = "./mcq.php";
  	}
  </script>
	
	<style>
		.centered {
		  position: fixed;
		  top: 50%;
		  left: 50%;
		  transform: translate(-50%, -50%);
		}
	</style>
</head>
<body style="background-color:#ff0000">
	<center class="centered">
		<h1 style="color:white;">
			Remaining Warning &nbsp <?php
			session_start();
			$_SESSION['WARNING']=$_SESSION['WARNING']-1;
			if($_SESSION['WARNING']<=0){
				echo "<script>window.close();</script>";
			} 
			echo $_SESSION['WARNING'];?>
		</h1>
		<h2 id="WARN">Click on the below button within the next <span id="t"></span> seconds.</h2>
		<button class="btn btn-success" onclick="redirect()">Continue To Test</button>
	</center>
	<script>
		var t=30;
		$(document).keydown(function(e){
			return false;
		});
		setInterval(function(){
			if(t==0){
				window.close();
			}else{
				t--;
				$('#t').html(t);
			}
		},1000);
	</script>
</body>
</html>
