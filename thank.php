<?php
	if(session_status()==1){
		session_start();
		//header("Location:./last.php");
	}
	
	$score = 0;
	$scoreArr = array(100);
	$opt = file('./TESTS/'.$_SESSION['subject'].'/'.$_SESSION['prn']);
	for ($i = 0; $i <count($_SESSION['QUESTIONS']); $i++) {
	$temp = $_SESSION['QUESTIONS'][$i];
    		if(intval($opt[$i])==intval($temp['ANSWER'])){
				$score++;
    			$scoreArr[$i] = '1';
    		}
    		else{
    			$scoreArr[$i] = '0';
    		}
	}
	
	include_once "./MongoDB.php";
	$obj = new MDB();
	$arr = array();
	$p = $_SESSION['prn'];
	$name = $obj->getName($p,$_SESSION['subject']);
	for($i=0;$i<count($_SESSION['QUESTIONS']);$i++)
	{
		$temp = $_SESSION['QUESTIONS'][$i];
		if(intval($opt[$i])==intval($temp['ANSWER'])){
				array_push($arr,'1');
    		}
    		else{
    			array_push($arr,'0');
    		}
	}

//$arr=array('PRN'=>$_SESSION['prn'],'1'=>$scoreArr[0],'2'=>$scoreArr[1],'3'=>$scoreArr[2],'4'=>$scoreArr[3],'5'=>$scoreArr[4],'6'=>$scoreArr[5],'7'=>$scoreArr[6],'8'=>$scoreArr[7],'9'=>$scoreArr[8],'10'=>$scoreArr[9]);//,'11'=>$scoreArr[10],'12'=>$scoreArr[11],'13'=>$scoreArr[12],'14'=>$scoreArr[13],'15'=>$scoreArr[14],'16'=>$scoreArr[15],'17'=>$scoreArr[16],'18'=>$scoreArr[17],'19'=>$scoreArr[18],'20'=>$scoreArr[19],'21'=>$scoreArr[20],'22'=>$scoreArr[21],'23'=>$scoreArr[22],'24'=>$scoreArr[23],'25'=>$scoreArr[24],'26'=>$scoreArr[25],'27'=>$scoreArr[26],'28'=>$scoreArr[27],'29'=>$scoreArr[28],'30'=>$scoreArr[29],'31'=>$scoreArr[30],'32'=>$scoreArr[31],'33'=>$scoreArr[32],'34'=>$scoreArr[33],'35'=>$scoreArr[34],'36'=>$scoreArr[35],'37'=>$scoreArr[36],'38'=>$scoreArr[37],'39'=>$scoreArr[38],'40'=>$scoreArr[39],'41'=>$scoreArr[40],'42'=>$scoreArr[41],'43'=>$scoreArr[42],'44'=>$scoreArr[43],'45'=>$scoreArr[44],'46'=>$scoreArr[45],'47'=>$scoreArr[46],'48'=>$scoreArr[47],'49'=>$scoreArr[48],'50'=>$scoreArr[49],'51'=>$scoreArr[50],'52'=>$scoreArr[51],'53'=>$scoreArr[52],'54'=>$scoreArr[53],'55'=>$scoreArr[54],'56'=>$scoreArr[55],'57'=>$scoreArr[56],'58'=>$scoreArr[57],'59'=>$scoreArr[58],'60'=>$scoreArr[59],'61'=>$scoreArr[60],'62'=>$scoreArr[61],'63'=>$scoreArr[62],'64'=>$scoreArr[63],'65'=>$scoreArr[64],'66'=>$scoreArr[65],'67'=>$scoreArr[66],'68'=>$scoreArr[67],'69'=>$scoreArr[68],'70'=>$scoreArr[69],'71'=>$scoreArr[70],'72'=>$scoreArr[71],'73'=>$scoreArr[72],'74'=>$scoreArr[73],'75'=>$scoreArr[74],'76'=>$scoreArr[75],'77'=>$scoreArr[76],'78'=>$scoreArr[77],'79'=>$scoreArr[78],'80'=>$scoreArr[79],'81'=>$scoreArr[80],'82'=>$scoreArr[81],'83'=>$scoreArr[82],'84'=>$scoreArr[83],'85'=>$scoreArr[84],'86'=>$scoreArr[85],'87'=>$scoreArr[86],'88'=>$scoreArr[87],'89'=>$scoreArr[88],'90'=>$scoreArr[89],'91'=>$scoreArr[90],'92'=>$scoreArr[91],'93'=>$scoreArr[92],'94'=>$scoreArr[93],'95'=>$scoreArr[94],'96'=>$scoreArr[95],'97'=>$scoreArr[96],'98'=>$scoreArr[97],'99'=>$scoreArr[98],'100'=>$scoreArr[99]);
	if($obj->checkscore($_SESSION['subject'],$p)){
		$obj->addScoreArr($_SESSION['subject'],$p,$name,$arr);
	}
	 
	 session_destroy();
?>



<html><head>
	<title>Registration</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="./css/bootstrap.min.css">
	<script src="./js/jquery.min.js"></script>
	<script src="./js/jquery.preloaders.js"></script>
	<script src="./js/bootstrap.min.js"></script>
	<script src="./js/custom.js"></script>
	<script src="./js/jquery.fullscreen.js"></script>

	<style>
		body,
		html {

			height: 100%;

			background-repeat: no-repeat;

			background-image: url('./img/thank.jpg');
			background-position: right;
			background-size: contain;
			position: relative;
			color: black;
		}
		pre{
			font-size:100;
			padding-top: 230;
			padding-left: 50;
			font-family: Impact	
		}
	</style>
</head>

<body>
	
	<pre>
Your Score<br/> is <?php echo $score;?>
	</pre>


</body>
<script>
window.addEventListener('popstate', function () {
    window.location="./last.php";
});
</script>
</html>
