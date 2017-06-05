<?php
$file_address='cache/pop';
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
$html = file_get_html($server.'/browse/popular/all/1');
$objects=[];
require 'filter_lang.php';

foreach ($html->find('tr') as $k=>$tr) {
	if($k==0)continue;
	$obj['Lang']=trim(str_replace("\t", '',($tr->find('.a1 span',0)->plaintext)));
	if(isset($lang)&&(strripos($lang,$obj['Lang'])=== false))continue;
	$obj["Name"]=trim(str_replace("\t", '',$tr->find('.a1 span text',1)->plaintext));
	$obj["Url"]=$tr->find('.a1 a[href]',0)->href;
	$obj['Owner']=trim(str_replace("\t", '',$tr->find('.a5',0)->plaintext));
	if((strpos($tr->innertext, 'neutral-icon') !== false))$obj['Rate']="Gray";
	$objects[]=$obj;
}
$seri=new ZJson($objects);
$ret= $seri->SerializeObject();
echo $ret;
$myfile = fopen($file_address, "w");
$ret=time().'#$#'.$ret;
fwrite($myfile, $ret);
fclose($myfile);