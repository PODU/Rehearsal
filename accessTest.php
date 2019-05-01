<html lang=''>
<head>
   <meta charset='utf-8'>
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="styles.css">
   <script src="menubar.js" type="text/javascript"></script>
   <script src="jquery.min.js" type="text/javascript"></script>
   
   <link rel="stylesheet" href="./css/bootstrap.min.js">
	<script src="./js/bootstrap.min.js"></script>
	<script src="./js/jquery.min.js"></script>
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   
   <script src="script.js"></script>
   <style>
   		button {
		    background-color: #4CAF50;
		    border: none;
		    color: white;
		    padding: 8px 32px;
		    text-align: center;
		    text-decoration: none;
		    display: inline-block;
		    font-size: 16px;
		    margin: 4px 2px;
		    cursor: pointer;
		}
		
		th,td
		{
			padding:15px;
		}
		
		
   </style>
   <script>
   		function redirect(){
   			window.location.href="./logout.php";
   		}
   		
   		function show(a) {
   			if(a==1){
   				$('.shower').hide();
   				$('#student').show();
   			}
   			if(a==2){
   				$('.shower').hide();
   				$('#questions').show();
   			}
   			if(a==3){
   				$('.shower').hide();
   				$('#score').show();
   			}
		}
   </script>
   <script>
		function exportToExcel(tableID,fileName='')
		{
			var downloadLink;
			var dataType = 'application/vnd.ms-excel';
			var tableSelect = document.getElementById(tableID);
	    		var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
	    		fileName = fileName?fileName+'.xls':'excel_data.xls';
	    		
			downloadLink = document.createElement("a");
			
			document.body.appendChild(downloadLink);
			    
			if(navigator.msSaveOrOpenBlob)
			{
				var blob = new Blob(['\ufeff', tableHTML], {
					type: dataType
				});
				navigator.msSaveOrOpenBlob( blob, fileName);
			}
			else
			{
				// Create a link to the file
				downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
			    
				// Setting the file name
				downloadLink.download = fileName;
				
				//triggering the function
				downloadLink.click();
			}
		}
	</script>
</head>
<body>
	
	<div id='cssmenu'>
		<ul>
		   <li class='active'><a href="javascript:show(1)" >Student</a></li>
		   <li><a href="javascript:show(2)">Questions</a></li>
		   <li><a href="javascript:show(3)">Score</a></li>
		   <button type="button" onclick="" style="float:right;">Remove Test</button>
		</ul>
		
	</div>
		
	<div id="student" class="shower" style="display:none">
		<center>
			<button class="btn btn-success">Download</button>
			<button class="btn btn-danger">Remove</button>
			<table style="margin-top:20px" border="1">
				<tr><th>Sr. No</th><th>PRN</th><th>Name</th><th>Password</th></tr>
				<?php
					$srno = 1;
					
					echo '<tr><td>'.$srno.'</td><td>'.$prn.'</td><td>'.$name.'</td><td>'.$password.'</td></tr>';
				?>
			</table>
		</center>
	</div>	
	
	<div id="questions" class="shower" style="display:none">
		<center>
			<table style="margin-top:50px" border="1">
				<tr><th>Question</th><th>Option 1</th><th>Option 2</th><th>Option 3</th><th>Option 4</th><th>Answer</th></tr>
				<?php
					
					echo '<tr><td>'.$que.'</td><td>'.$op1.'</td><td>'.$op2.'</td><td>'.$op3.'</td><td>'.$op4.'</td><td>'.$ans.'</td></tr>';
				?>
			</table>
		</center>
	</div>
	
	<div id="score" class="shower" >
		<center>
			<button onclick="exportToExcel('report','report')" class="btn btn-success">Download</button>
			<button class="btn btn-danger">Remove</button>
			<table id="report" style="margin-top:50px;" border="1">
				<tr><th>Sr No</th><th>PRN</th>
				<?php
					include_once "./MongoDB.php";
					$obj = new MDB();
					$conn = new MongoClient();
					$collection = $conn->COLLEGE->studentLogin;
					$cursor = $collection->findOne();
					
					$test = 'score'.$cursor['TEST'];
					$collection = $conn->COLLEGE->$test;
					$cursor = $collection->findOne();
					
					$cnt = count($cursor)-2;
							for($j=1;$j <= $cnt;$j++){
								echo '<th>Q'.$j.'</th>';
							}
					echo '<th>Score</th>';
					
					//errorlog($conn->COLLEGE->lastError(),"../");
					/*foreach($cursor as $doc){
						$id = $doc['TEST'];
						$prn = $doc['PRN'];
						
						$id = 'score'.trim($id);
						$prn = trim($prn);
						$collection = $conn->COLLEGE->$id;
						$query = array('PRN'=>$prn);
						$arr = $collection->find($query);
						$i = 0;
						
						foreach($arr as $doc){
							$cnt = count($doc)-2;
							for($j=1;$j <= $cnt;$j++){
								echo '<th>Q'.$j.'</th>';
							}
							break;
							/*if($i!=0){
								echo '<th>Q'.$i.'</th>';
							}
							$i++;*/
							//$doc['PRN'],$doc['1'],$doc['2'],$doc['3'],$doc['4'],$doc['5']);
						//}
						//break;
						/*foreach($arr as $a){
							echo '<h1> arr = '.$a[0].' '.$a[1].'</h1>';
						}
						//echo '<h1>id = '.$doc['TEST'].' prn '.$doc['PRN'].'</h1><br>';
					}*/
				?>
				</tr>
				<?php
					
					include_once "./MongoDB.php";
					$obj = new MDB();
					$conn = new MongoClient();
					$collection = $conn->COLLEGE->studentLogin;
					$cursor = $collection->findOne();
					
					$test = 'score'.$cursor['TEST'];
					$collection = $conn->COLLEGE->$test;
					$cursor = $collection->find();
					
					foreach($cursor as $arr)
					{
						echo '<tr>';
						$res = 0;
						$sr = 1;
						echo '<td>'.$sr++.'</td>';
						echo '<td>'.$arr['0'].'</td>';
						for($i=1;$i<count($arr)-1;$i++)
						{
							echo '<td>'.$arr[$i].'</td>';
							if($arr[$i] == "1")
								$res++;
						}
						echo '<td>'.$res.'</td>';
						echo '</tr>';					
					}
				?>
			</table>
		</center>
	</div>

</body>
<html>
