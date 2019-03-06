<?php
require 'head.php';
require 'html_dom.php';
//use cachd
$file_address='cache/home';
$sv=file_get_contents($file_address);
if(strlen($sv)>2){
	$sv=explode('#$#',$sv);
	if(time()-$sv[0]<50000){
		echo $sv[1];
		exit();
	}
}

$html = file_get_html($server);
if(strlen($html)<1) die();
// ["NumberOfSubtitle"=> "","Name"=> "", "Url"=> "","ImgSrc"=>"","ImdbUrl"=> "","Year"=> ""];
$objects = array();
$images=[];
$imdbs=[];
$urls=[];
$names=[];
foreach($html->find('div[class=poster] img') as $element) 
	$images[]=$element->src;
foreach($html->find('div[class=title]') as $element) {
	$urls[]=$element->find('a',0)->href;
	$names[]=$element->find('a',0)->innertext;
	$imdbs[]=$element->find('a',1)->href;
}
foreach($urls as $k=>$e)
	$objects[]=["Name"=> $names[$k],"Url"=> $e,"ImgSrc"=>$images[$k],"ImdbUrl"=> $imdbs[$k]];
//caching
$ret= json_encode($objects, JSON_UNESCAPED_UNICODE);
echo $ret;
$myfile = fopen($file_address, "w");
$ret=time().'#$#'.$ret;
fwrite($myfile, $ret);
fclose($myfile);