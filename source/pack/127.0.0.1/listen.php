<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=utf-8");
$dir = $_GET['dir'];
$file = 'work/'.$dir.'/old.ipa';
if(!is_file($file)){
        echo '1';
}
?>