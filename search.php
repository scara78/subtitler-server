<?php
require 'html_dom.php';
require 'jsonhandler.php';
require 'find_server.php';
if (!isset($_GET['search'])) die();
$search=str_replace(" ", "+",$_GET['search']);
$url=$server.'/subtitles/title?q='.$search;
$html = file_get_html($url);
$objects=[];
foreach ($html->find('div[class=title] a[href]') as $v) {
	$urls[]=$v->href;
	$names[]=$v->plaintext;
}
foreach ($html->find('[class=subtle count]') as $k=>$v) {
	$nums=$v->plaintext;
	$objects[]=["NumberOfSubtitle"=>$nums,"Name"=> $names[$k],"Url"=> $urls[$k]];
}

$seri=new ZJson($objects);
echo $seri->SerializeObject();