<?php
if(isset($_GET['lang'])){
//	if(strtolower($_GET['lang'])!="all" && $_GET['lang'][1]!='0'){
//		$l=json_decode($_GET['lang']);
$slang=["English","Farsi/Persian","Arabic","Brazillian Portuguese","Danish","Dutch","Finnish","French","Hebrew","Indonesian","Italian","Norwegian","Romanian","Spanish","Swedish","Vietnamese","Hindi","Russian"];
	$lang=$slang[$_GET['lang']];	
}