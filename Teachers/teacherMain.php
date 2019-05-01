<html lang=''>

<head>
    <meta charset='utf-8'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/jquery-ui.min.css">
	<script src="../js/popper.min.js"></script>
	<script src="../js/jquery.min.js"></script>
	<script src="../js/jquery-ui.min.js"></script>
	<script src="../js/loadingoverlay.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
</head>

<body style="background-color:gray;">
    <center>
        <div style="width:90vw;min-height: 90vh;margin-top: 5vh;padding-top: 5vh;padding-bottom: 5vh;background-color: white;box-shadow:0 10px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19) !important;">
            <div style="width:90vw;padding-right:2vw;padding-left:2vw;">
                <span style="float:left;">
                    Hello, <span><?php session_start(); echo $_SESSION['NAME'];?></span>
                </span>
                <span style="float:right;">
                    <button class="btn btn-primary" onclick="signout()">LogOut</button>
                </span>
            </div>
            <br>
            <hr>
            <div id="mainscreen">
                
            </div>
        </div>
    </center>
</body>
<script>
$(document).ready(function(){
    $('.ip').focusin(function(){
        if($('#first').val()==""){
            $('#first').focus();
        }
    });
    $('#first').bind('paste',null,function(e){
        $this = $(this);
        setTimeout(function() {
            var column = $this.val();
            var trs="<tr><td>PRN</td><td>NAME</td><td>PASSWORD</td></tr>";
            alert(column);
        }, 0);
    });
    changePage('home.html');
});
function changePage(p){
    $('#mainscreen').hide('slide',{direction:'left'},100);
    $.LoadingOverlay("show");
    $.ajax({
        url:'../ajax/changepage.php',
        type:'GET',
        data:{page:p},
        success:function(res){
            $('#mainscreen').html(res);
            $('#mainscreen').show('slide',{direction:'left'},750);
            $.LoadingOverlay("hide");
        }
    });
}
function loadTable(){
    $.LoadingOverlay("show");
    $.ajax({
        url:'../ajax/getActiveList.php',
        success: function(res){
            var asd = JSON.parse(res);
            var r = "<tr><td>Sr No.</td><td>Subject</td><td>Access Test</td></tr>";
            for(var i=0;i<asd.length;i++){
                var s = asd[i].split('#####');
            	r = r + "<tr><td>"+(i+1)+"</td><td valign=\"middle\">"+s[0]+"</td><td><a href=\"./accessTest.php?test="+s[1]+"\"><button type=\"button\" class=\"btn btn-success\" \">ACCESS TEST</button></a></td></tr>";
                //r = r + "<tr><td>"+(i+1)+"</td><td valign=\"middle\">"+asd[i].SUBJECT+"</td><td><button type=\"button\" class=\"btn btn-success\" onclick=\"redirect(\'"+asd.SUBJECT+"#####"+asd.BY+"\')\">ACCESS TEST</button></td></tr>";
            }
            $('#activeList').html(r);
            $.LoadingOverlay("hide");
        }
    });
}
function redirect(s){
    window.location.href="./testaccess.php?asd="+s;
}
function redirect1(s){
    window.location.href=s;
}
function direct(s){
    changePage("setTest1.html");
}
function signout(){
    window.location.href="./signout.php";
}
history.pushState(null, null, document.url);
window.addEventListener('popstate', function () {
    changePage('home.html');
});
</script>
<html>
