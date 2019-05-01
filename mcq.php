<?php
session_start();

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
#feedback { font-size: 1.4em; }
#selectable .ui-selecting { background: #FECA40; }
#selectable .ui-selected { background: #7EFE00; color: black; }
.ui-widget-content:hover {background:#DCDCDC;color:black;}
#selectable { list-style-type: none; margin: 0; padding: 0; width: 100%; }
#selectable li { margin: 3px; padding: 0.4em; font-size: 1.4em; height: 100%;border:black solid 1px; }
.nothing {}
.selected {background:#7EFE00;color:black;}
.unselected {background:#fff;color:black;}

body, html {
height: 100%;
background-repeat: no-repeat;
background-color:#F5F5F5;
background-position: center;
background-size: cover;
position: relative;
color:black;
overflow:hidden;
}
.wordwrap {
white-space: pre-wrap;
white-space: -moz-pre-wrap;
white-space: -pre-wrap;
white-space: -o-pre-wrap;
word-wrap: break-word;
}
</style>

</head>
<body  oncontextmenu="return false;" style="overflow-y:visible;overflow-x:hidden;">
<div>
<span style="width:76%;float:left;overflow-y:auto;">
<center>
<div style="padding-bottom:20px;background-color:white;margin-top:5vh;min-height:90vh;overflow-y:auto;">
<div>
<h1 style="float:right;margin-top:1vw;margin-right:1vw;" id="timer">QNO</h1>
</div>
<br>
<br>
<br>
<hr>
<div>
<h3 style="float:right;margin-top:1vw;margin-right:1vw;" id="QNO">QNO</h3>
</div>
<div style="margin-left:3vw;margin-right:3vw;font-size:25px;text-align:left;overflow:visible;" class="wordwrap">
<pre class="wordwrap" id="question">
QUESTION
</pre>
    </div>
                    <div id="opt" style="margin-left:3vw;margin-right:3vw;text-align:left;overflow:visible;" class="wordwrap">
<div>
    <div style="border:2px solid black;font-size:20px;" class="nothing" id="option1" onclick='optionselect(1)'>OP1</div>
    <div style="border:2px solid black;font-size:20px;" class="nothing" id="option2" onclick='optionselect(2)'>OP2</div>
    <div style="border:2px solid black;font-size:20px;" class="nothing" id="option3" onclick='optionselect(3)'>OP3</div>
    <div style="border:2px solid black;font-size:20px;" class="nothing" id="option4" onclick='optionselect(4)'>op4</div>
</div>
<a id="clear" href="javascript:clear()">Clear Response</a>
                    </div>
<div>
    <table>
        <tr style="width:80vw;">
            <td style="width:40vw;float:left;"><center><button id="previous" class="btn btn-info"><h4>Previous</h4></button></center></td>
            <td style="width:40vw;float;right;"><center><button id="next" class="btn btn-info"><h4>Next</h4></button><button id="submit" class="btn btn-info" style="display:none;">Submit Test</button></center></td>
        </tr>
    </table>
</div>

</div>
</center>
</span>
<span style='margin-top:30px;float:right;width:285px;overflow-y:scroll;'>
<?php
echo "<table>";
for($i=1;$i<=count($_SESSION['QUESTIONS']);$i++){
        echo "<tr>";
        while($i%5!=0 && $i<count($_SESSION['QUESTIONS'])){
            echo "<td><button onClick='jump(this)' style='width:50px;color:white;background-color: #4CAF50;border-radius: 50%;height: 50px;'>".$i."</button></td>";
            $i++;
        }
        echo "<td><button onClick='jump(this)' style='width:50px;color:white;background-color: #4CAF50;border-radius: 50%;height: 50px;'>".$i."</button></td>";
        echo "</td></tr>";
}
echo "</table>";
?>
</span>
</div>
</body>
<script>
$( function() {
    $('body').focus();
});
function clear(){
    if($('#option1').hasClass('selected')){$('#option1').removeClass('selected');}
    if($('#option2').hasClass('selected')){$('#option2').removeClass('selected');}
    if($('#option3').hasClass('selected')){$('#option3').removeClass('selected');}
    if($('#option4').hasClass('selected')){$('#option4').removeClass('selected');}
    optionselect(0);
    $('.ui-widget-content').removeClass('ui-selected');
}
$(document).keydown(function(e){
		return false;
});
history.pushState(null, null, document.url);
window.addEventListener('popstate', function () {
    window.location="./last.php";
});
function optionselect(assd){
$('#clear').show();
    $.ajax({
        url:'./ajax/setAnswer.php',
        type:'GET',
        data:{val:assd,qno:(parseInt($('#QNO').html())-1)},
        success: function(res){
        }
    });
}
function getQuestion(num){
    $.LoadingOverlay("show");
    $.ajax({
        url:'./ajax/getQuestion.php',
        type:'GET',
        data:{number:num},
        success:function(res){
            var obj = JSON.parse(res);
            $('#QNO').html((parseInt(num)+1));
            $('#question').html(obj.QUESTION);
            $('#option1').html(obj.OPTION1);
            $('#option2').html(obj.OPTION2);
            $('#option3').html(obj.OPTION3);
            $('#option4').html(obj.OPTION4);
            $('.ui-widget-content').removeClass('ui-selected');
            $.ajax({
                url:'./ajax/getSelected.php',
                type:'GET',
                data:{'qno':num},
                async:false,
                success:function(res) {
                    if(parseInt(res)!=0){
                        $('#option'+res).addClass('selected');
                    }
                }
            });
            if(parseInt(num)==0){
                $('#previous').hide();
                $('#submit').hide();
                $('#next').show();
            }else if(parseInt(num)==<?php echo (count($_SESSION['QUESTIONS'])-1); ?>){
                $('#previous').show();
                $('#submit').show();
                $('#next').hide();
            }else{
                $('#previous').show();
                $('#submit').hide();
                $('#next').show();
            }
            $.LoadingOverlay("hide");
        }

    });
}



$(document).ready(function(){
    setInterval(function(){
        $.ajax({
            url:'./ajax/getTime.php',
            success:function(res){
            	if(parseInt(res)!=0){
		            var sec = parseInt(res)%60;
		            var minn = parseInt(parseInt(res)/60);
		            $('#timer').html(minn+":"+sec);
		        }
		        else{
		        	 window.close();
		        }
            }
        });
    },1000);
    getQuestion(0);
    $('#next').click(function(){
        if($('#option1').hasClass('selected')){$('#option1').removeClass('selected');}
        if($('#option2').hasClass('selected')){$('#option2').removeClass('selected');}
        if($('#option3').hasClass('selected')){$('#option3').removeClass('selected');}
        if($('#option4').hasClass('selected')){$('#option4').removeClass('selected');}
        var num = parseInt($('#QNO').html());
        getQuestion(num);
    });
    $('#previous').click(function(){
        if($('#option1').hasClass('selected')){$('#option1').removeClass('selected');}
        if($('#option2').hasClass('selected')){$('#option2').removeClass('selected');}
        if($('#option3').hasClass('selected')){$('#option3').removeClass('selected');}
        if($('#option4').hasClass('selected')){$('#option4').removeClass('selected');}
        var num = parseInt($('#QNO').html());
        getQuestion(num-2);
    });
    $('#submit').click(function(){
        window.location="./thank.php";
    });

    

    //$('body').mouseleave(function(){
    //    window.location.href = './warning.php';
    //});
});

$('#option1').click(function(){
    if($('#option1').hasClass('selected')){
    }else{
        $('#option1').addClass('selected');
        if($('#option2').hasClass('selected')){$('#option2').removeClass('selected');}
        if($('#option3').hasClass('selected')){$('#option3').removeClass('selected');}
        if($('#option4').hasClass('selected')){$('#option4').removeClass('selected');}
    }
});

$('#option2').click(function(){
    if($('#option2').hasClass('selected')){
    }else{
        $('#option2').addClass('selected');
        if($('#option1').hasClass('selected')){$('#option1').removeClass('selected');}
        if($('#option3').hasClass('selected')){$('#option3').removeClass('selected');}
        if($('#option4').hasClass('selected')){$('#option4').removeClass('selected');}
    }
});

$('#option3').click(function(){
    if($('#option3').hasClass('selected')){
    }else{
        $('#option3').addClass('selected');
        if($('#option2').hasClass('selected')){$('#option2').removeClass('selected');}
        if($('#option1').hasClass('selected')){$('#option1').removeClass('selected');}
        if($('#option4').hasClass('selected')){$('#option4').removeClass('selected');}
    }
});

$('#option4').click(function(){
    if($('#option4').hasClass('selected')){
    }else{
        $('#option4').addClass('selected');
        if($('#option1').hasClass('selected')){$('#option1').removeClass('selected');}
        if($('#option3').hasClass('selected')){$('#option3').removeClass('selected');}
        if($('#option2').hasClass('selected')){$('#option2').removeClass('selected');}
    }
});

function jump(number){
    if($('#option1').hasClass('selected')){$('#option1').removeClass('selected');}
    if($('#option2').hasClass('selected')){$('#option2').removeClass('selected');}
    if($('#option3').hasClass('selected')){$('#option3').removeClass('selected');}
    if($('#option4').hasClass('selected')){$('#option4').removeClass('selected');}
    var num = number.innerText;
    getQuestion(num-1);
}

/*function optionSelect(var opt){
    alert(opt);
}*/
window.addEventListener('popstate', function () {
    window.location="./last.php";
});
</script>

</html>
