<?php
require 'find_server.php';
$url=$server.'/subtitle/download?mac='.$_GET['mac'];
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-type: application/octet-stream");
// header("Content-Disposition: attachment; filename=\"".$filename."\"");
header("Content-Transfer-Encoding: binary");
// header("Content-Length: ".filesize($filepath.$filename));

        
readfile($url); 