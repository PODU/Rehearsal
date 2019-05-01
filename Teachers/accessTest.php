<?php
$id = $_GET['test'];
include_once "../MongoDB.php";
$obj = new MDB();
$conn = new MongoClient();
?>
<html lang=''>
<head>
   <meta charset='utf-8'>
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="../css/styles.css">
   <script src="../js/menubar.js" type="text/javascript"></script>
   
   <link rel="stylesheet" href="../css/bootstrap.min.js">
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/jquery.min.js"></script>
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
	   function delS(a){
		   $.ajax({
			   url:'../ajax/deleteStudent.php',
			   type:'GET',
			   data:{'id':a},
			   success:function(res){
				location.reload();
			   }
		   });
	   }
	   function delQ(a){
		   $.ajax({
			   url:'../ajax/deleteQuestion.php',
			   type:'GET',
			   data:{'id':a},
			   success:function(res){
				location.reload();
			   }
		   });
	   }

	   function removeTest(){
		   
			$.ajax({
				url:'../ajax/deleteAllScores.php',
				type:'GET',
				data:{'testID':'<?php echo $id;?>'},
				success:function(res){
					$.ajax({
						url:'../ajax/deleteAllQuestion.php',
						type:'GET',
						data:{'testID':'<?php echo $id;?>'},
						success:function(res){
							$.ajax({
								url:'../ajax/deleteAllStudent.php',
								type:'GET',
								data:{'testID':'<?php echo $id;?>'},
								success:function(res){
									$.ajax({
										url:'../ajax/deleteTest.php',
										type:'GET',
										async:false,
										data:{'ID':'<?php echo $id;?>'},
										success:function(res){
											window.location.href="./";
										}
									});
								}
							});
						}
					});
				}
			});
	   }

	   function removeScoreAll(){
			$.ajax({
				url:'../ajax/deleteAllScores.php',
				type:'GET',
				data:{'testID':'<?php echo $id;?>'},
				success:function(res){
					location.reload();
				}
			});
	   }

	   function removeQuestionsAll(){
			$.ajax({
				url:'../ajax/deleteAllQuestion.php',
				type:'GET',
				data:{'testID':'<?php echo $id;?>'},
				success:function(res){
					location.reload();
				}
			});
	   }

	   function removeStudentAll(){
			$.ajax({
				url:'../ajax/deleteAllStudent.php',
				type:'GET',
				data:{'testID':'<?php echo $id;?>'},
				success:function(res){
					location.reload();
				}
			});
	   }

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
			if(a==4){

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
		   <li><a href="javascript:show(4)">Analyze</a></li>
		   <button type="button" onclick="removeTest()" style="float:right;background-color:red;">Remove Test</button>
		</ul>
		
	</div>
		
	<div id="student" class="shower" style="display:none">
		<center>
			<button onclick="exportToExcel('student','student_list')" class="btn btn-success">Download</button>
			<button class="btn btn-danger" style="background-color:red;" onclick="removeStudentAll()">Remove</button>
			<table style="margin-top:20px" id="student" border="1">
				<tr><th>Sr. No</th><th>PRN</th><th>Name</th><th>Password</th><th>Delete</th></tr>
				<?php
					$srno = 1;
					$connection = $conn->COLLEGE->studentLogin;
					$res = $connection->find(array('TEST'=>$id));
					foreach($res as $r){
						echo '<tr><td>'.$srno.'</td><td>'.$r['PRN'].'</td><td>'.$r['NAME'].'</td><td>'.$r['PASSWORD'].'</td><td><button class="btn" style="background-color:red;color:white;" id="del'.$srno.'" onclick="delS(\''.$r['_id'].'\')"><b>X</b></button></td></tr>';
						$srno = $srno+1;
					}
				?>
			</table>
		</center>
	</div>	
	<div id="analyze" class="shower" style="display:none">
		<center>
			<button onclick="exportToExcel('analyze','analysis')" class="btn btn-success">Download</button>
			<table style="margin-top:20px" id="analyze" border="1">
				<tr><th>Sr. No</th><th>PRN</th><th>Name</th><th>Password</th><th>Delete</th></tr>
				<?php
					$srno = 1;
					$connection = $conn->COLLEGE->studentLogin;
					$res = $connection->find(array('TEST'=>$id));
					foreach($res as $r){
						echo '<tr><td>'.$srno.'</td><td>'.$r['PRN'].'</td><td>'.$r['NAME'].'</td><td>'.$r['PASSWORD'].'</td><td><button class="btn" style="background-color:red;color:white;" id="del'.$srno.'" onclick="delS(\''.$r['_id'].'\')"><b>X</b></button></td></tr>';
						$srno = $srno+1;
					}
				?>
			</table>
		</center>
	</div>
	<div id="questions" class="shower" style="display:none">
		<center>
			<button onclick="exportToExcel('question','question_list')" class="btn btn-success">Download</button>
			<button class="btn btn-danger" style="background-color:red;" onclick="removeQuestionsAll()">Remove</button>
			<table style="margin-top:50px" id="question" border="1">
				<tr><th>Sr. No.</th><th>Question</th><th>Option 1</th><th>Option 2</th><th>Option 3</th><th>Option 4</th><th>Answer</th><th>CO</th><th>Type</th><th>Delete</th></tr>
				<?php
					$srno=1;
					$connection = $conn->COLLEGE->questionList;
					$res = $connection->find(array('TEST'=>$id));
					foreach($res as $r){
						echo '<tr><td>'.$srno.'</td><td>'.$r['QUESTION'].'</td><td>'.$r['OPTION1'].'</td><td>'.$r['OPTION2'].'</td><td>'.$r['OPTION3'].'</td><td>'.$r['OPTION4'].'</td><td>'.$r['ANSWER'].'</td><td>'.$r['CO'].'</td><td>'.$r['TYPE'].'</td><td><button style="background-color:red;color:white;" onclick="delQ(\''.$r['_id'].'\')"><b>X</b></button></td></tr>';
						$srno = $srno+1;
					}
				?>
			</table>
		</center>
	</div>
	
	<div id="score" class="shower" style="display:none;">
		<center>
			<button onclick="exportToExcel('report','report')" class="btn btn-success">Download</button>
			<button class="btn btn-danger" style="background-color:red;" onclick="removeScoreAll()">Remove</button>
			<table id="report" style="margin-top:50px;" border="1">
				<tr><th>Sr No</th><th>PRN</th><th>Name</th>
				<?php
					$collection = $conn->COLLEGE->studentLogin;
					$cursor = $collection->find(array('TEST'=>$id));
					$prns = array();
					foreach($cursor as $doc){
						if(!in_array($doc['PRN'],$prns)){
							array_push($prns,$doc['PRN']);
						}
					}
					$cnt = count($obj->getQuestionList($id));
					for($j=1;$j <= $cnt;$j++){
						echo '<th>Q'.$j.'</th>';
					}
					echo '<th>Score</th>';
				
				?>
				</tr>
				<?php
					$collection = $conn->COLLEGE->scoreList;
					$cursor = $collection->find(array('TEST'=>$id));
					
					foreach($cursor as $arr)
					{
						echo '<tr>';
						$res = 0;
						$sr = 1;
						echo '<td>'.$sr++.'</td>';
						echo '<td>'.$arr['PRN'].'</td>';
						echo '<td>'.$arr['NAME'].'</td>';
						$a = $arr['SCORE'];
						for($i=0;$i<count($a);$i++)
						{
							echo '<td>'.$a[$i].'</td>';
							if($a[$i] == "1")
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
<script>
$(document).ready(function(){
	show(1);
});
</script>
<html>
