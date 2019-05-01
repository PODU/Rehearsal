<?php

$page = $_GET['page'];

$text = file_get_contents("../Teachers/pages/".$page);

echo $text;

?>