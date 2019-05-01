<html>

<head>
	<title>Registration</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="./css/bootstrap.min.css">
	<link rel="stylesheet" href="./css/jquery-ui.min.css">
	<script src="./js/popper.min.js"></script>
	<script src="./js/jquery.min.js"></script>
	<script src="./js/jquery-ui.min.js"></script>
	<script src="./js/loadingoverlay.min.js"></script>
	<script src="./js/bootstrap.min.js"></script>

	<style>
		body,
		html {

			height: 100%;

			background-repeat: no-repeat;

			background-image: url('./img/back.jpg');
			background-position: center;
			background-size: cover;
			position: relative;
			color: black;
		}
		.epli {
			display: inline-block;
			width: 40vw;
			white-space: nowrap;
			overflow: hidden !important;
			text-overflow: ellipsis;
    	}
	</style>
</head>
<script>
		$(document).ready(function(){
			$(document).keydown(function(e){
				if(e.keyCode == 123) {
					return false;
				}
				if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){
					return false;
				}
				if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){
					return false;
				}
				if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){
					return false;
				}
				if(e.keyCode==116){
					return false;
				}
				if(e.shiftKey && e.keyCode == 115){
					return false;
				}
				if(e.ctrlKey && e.shiftKey && e.keyCode == 'M'.charCodeAt(0)){
					return false;
				}
				if(e.shiftKey && e.keyCode == 119){
					return false;
				}
				if(e.shiftKey && e.keyCode == 120){
					return false;
				}
				if(e.ctrlKey && e.shiftKey && e.keyCode == 'E'.charCodeAt(0)){
					return false;
				}
				if(e.shiftKey && e.keyCode == 116){
					return false;
				}
				if(e.shiftKey && e.keyCode == 118){
					return false;
				}
				if(e.ctrlKey && e.shiftKey && e.keyCode == 'S'.charCodeAt(0)){
					return false;
				}
				if(e.ctrlKey && e.keyCode == 'S'.charCodeAt(0)){
					return false;
				}
				if(e.ctrlKey && e.shiftKey && e.keyCode == 'K'.charCodeAt(0)){
					return false;
				}
				if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)){
					return false;
				}
				if(e.ctrlKey && e.keyCode == 'R'.charCodeAt(0)){
					// TODO:- Remove Comment
					//return false;
				}
			});
		});

		var name=false,prn=false,pass=false,cls=false,sub=false;
		function Validate() {
			var v = $('#prn').val();
			if(v==null){
				alert("Enter a valid PRN Number.");
				return false;
			}else{
				var r = v.match(/[0-9]/g);
				if(r!=null&&(v.length-r.length)==1){
					prn=true;
				}else{
					prn=false;
					alert("Enter a valid PRN Number.");
					return false;
				}
			}
			var v = $('#password').val();
			if(v==null){
				alert("Enter a valid Password.");
				return false;
			}else{
				var r = v.match(/[0-9]/g);
				if(r!=null && r.length==v.length && v.length==6){
					pass=true;
				}else{
					pass=false;
					alert("Enter a valid Password.");
					return false;
				}
			}
			if($('#inputGroupSelect02').val()=="0"){
				alert("Please Select a Subject");
				return false;
			}
			$.LoadingOverlay("show");
			var auth="IN";
			$.ajax({
				url:'./ajax/getAuthenticated.php',
				async:false,
				type:'GET',
				data:{username:$('#prn').val(),password:$('#password').val(),test:$('#inputGroupSelect02').val()},
				success: function(res){
					$.LoadingOverlay("hide");
					if(res.includes("FALSE")){
						$('#WARNING').show();
						auth="FAIL";
					}else{
						auth="DONE";
					}
				}
			});
			while(auth=="IN"){
			}
			if(auth=="FAIL"){
				return false;
			}else{
				var x = $('#prn').val();
				var y = $('#password').val();
				var z = $('#inputGroupSelect02').val();
				window.location.href="./start.php?prn="+x.split(' ').join('+')+"&password="+y+"&subject="+z;
				//window.open(_blank","fullscreen=yes,menubar=no,resizable=no,titlebar=no,toolbar=no");
				return false;
			}
		}
	</script>

<body>
	<div oncontextmenu="return false;" style="overflow:hidden;" class="container">
		<center>
			<form name="drform" style="background-color:white;margin-top:20vh;width:50vw;padding-bottom: 10px;" class="form-horizontal" method="GET"
			 action="#" onsubmit="return Validate()">
				<br><br>
				<div>
					<h2>
						<center><i>MOCK TEST</i></center>
					</h2>
				</div>
				<div class="form-group">
						<div class="com-sm-10">
							<input type="text" class="form-control" style="width:40vw;" name="prn" id="prn" placeholder="Enter PRN Number." required>
						</div>
				</div>
				<div class="form-group">
						<div class="com-sm-10">
							<input type="text" class="form-control" style="width:40vw;" name="password" id="password" placeholder="Enter Password." required>
						</div>
				</div>
				<div class="form-group">
						<div class="com-sm-10">
								<div class="input-group mb-3" style="width:40vw;">
										<div class="input-group-prepend">
										  <label class="input-group-text" for="inputGroupSelect02">Subject</label>
										</div>
										<select class="custom-select" name="subject" id="inputGroupSelect02">
											<option value="0">Select Subject</option>
										  <?php
include_once "./MongoDB.php";
$obj = new MDB();
$res = $obj->getActiveSubjectList();
foreach ($res as $sub) {
    echo "<option class=\"epli\" value=\"".$sub['ID']."\">".$sub['BY'].":-".$sub['SUBJECT']."</option>";
}
?>
										</select>
									  </div>
						</div>
				</div>
				<div class="form-group">
						<div style="color:red;display:none;" id="WARNING" class="com-sm-10">
							Either PRN or Password is Wrong
						</div>
				</div>
				<div class="form-group">
						<div class="com-sm-10">
							<button type="submit" class="btn btn-primary">Submit</button>
						</div>
				</div>
			</form>
		</center>
	</div>
</body>

</html>