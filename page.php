<?php
require_once 'html_dom.php';
require 'jsonhandler.php';
require 'find_server.php';
require 'filter_lang.php';
ini_set('memory_limit', '556M');

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);
if (!isset($_GET['url'])) die();
$url=($server.($_GET['url']));
$objects=[];$main=[];
if(isset($_GET['lang'])){
	try{
		$LanguageFilter_Cookies=[13,46,2,4,10,11,17,18,22,44,26,30,33,38,39,45,51,34];
		// $opts = array('http'=>array('header'=> 'Cookie: '."LanguageFilter=".$LanguageFilter_Cookies[$_GET['lang']]."\r\n"));
		// $context = stream_context_create($opts);
		// $html = file_get_html($url,false,$context);
		// $html = file_get_html($url,false,"LanguageFilter=".$LanguageFilter_Cookies[$_GET['lang']]);
		$ch = curl_init();
		$headers = array('X-Auth-Email: user@emailaddress.com','X-Auth-Key: d820fa8fc881921323e08a2c19b8347896ac26','Content-Type: application/json');

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 60);
		curl_setopt($ch, CURLOPT_TIMEOUT , 60);

		curl_setopt($ch, CURLOPT_HEADER, 1);
		// curl_setopt($ch, CURLOPT_HTTPGET, 1);
		// curl_setopt($ch, CURLOPT_DNS_USE_GLOBAL_CACHE, false );
		// curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 2 );
		// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$str = curl_exec($ch);
		curl_close($ch);
		$html= new simple_html_dom();
		$html->load($str);
		echo "<pre>";
	}catch(Exception $ex){
		$html = '';
	}
}else{
	$html = file_get_html($url);
}
// echo curl_strerror(6);
if(strlen($html)<1)die();
try {
	$main['ImdbUrl']=$html->find('a.imdb',0)->href;
} catch (Exception $e) {
	$main['ImdbUrl']="";
}
try {
	$main['ImgSrc']=$html->find('img[alt=Poster]',0)->src;
} catch (Exception $e) {
	$main['ImgSrc']="";
}
$main['Year']=trim(str_replace("\t", " ", $html->find('div.header ul li',0)->plaintext));
foreach ($html->find('tr') as $k=>$tr) {
	if($k==0 )continue;
	if((strpos($tr->innertext, 'subtitle') == false))continue;
	try{
		$obj['Lang']=trim(str_replace("\t", '',($tr->find('td.a1 span',0)->plaintext)));
		if(isset($lang)&&(strripos($lang,$obj['Lang'])=== false))continue;
	}catch(Exception $e){
		continue;
	}
	$obj["Name"]=trim(str_replace("\t", '',$tr->find('td.a1 span text',1)->plaintext));
	$obj["Url"]=$tr->find('td.a1 a[href]',0)->href;
	$obj['Owner']=trim(str_replace("\t", '',$tr->find('td.a5',0)->plaintext));
	if((strpos($tr->innertext, 'neutral-icon') !== false))$obj['Rate']="Gray";
	$objects[]=$obj;
}
$seri=new ZJson($main);
echo $seri->SerializeObject().'.*.';
$seri=new ZJson($objects);
echo $seri->SerializeObject();
