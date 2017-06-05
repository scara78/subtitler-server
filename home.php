<?php
$file_address='cache/home';
$sv=file_get_contents($file_address);
if(strlen($sv)>2){
	$sv=explode('#$#',$sv);
	if(time()-$sv[0]<50000){
		echo $sv[1];
		exit();
	}
}
require 'html_dom.php';
require 'jsonhandler.php';
require 'find_server.php';
$html = file_get_html($server);
if(strlen($html)<1)die();
// $bigpicture=["NumberOfSubtitle"=> "","Name"=> "",
// "Url"=> "","ImgSrc"=>"","ImdbUrl"=> "","Year"=> ""];
$objects = array();
$images=[];$imdbs=[];$urls=[];$names=[];
foreach($html->find('div[class=poster] img') as $element) 
	$images[]=$element->src;
foreach($html->find('div[class=title]') as $element) {
	$urls[]=$element->find('a',0)->href;
	$names[]=$element->find('a',0)->innertext;
	$imdbs[]=$element->find('a',1)->href;
}
foreach($urls as $k=>$e){
	$objects[]=["Name"=> $names[$k],"Url"=> $e,"ImgSrc"=>$images[$k],"ImdbUrl"=> $imdbs[$k]];
}
$z=new ZJson($objects);
$ret= $z->SerializeObject();
echo $ret;
$myfile = fopen($file_address, "w");
$ret=time().'#$#'.$ret;
fwrite($myfile, $ret);
fclose($myfile);