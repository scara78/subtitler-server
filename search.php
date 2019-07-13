<?php
require 'head.php';
if (!isset($_GET['q'])) die();
$search = str_replace(" ", "+", $_GET['q']);
#https://subscene.xyz/subtitles/searchbytitle?query=hellboy&l=
$url = $server . '/subtitles/searchbytitle?q=' . $search;
$objects = [];
try{
	require 'html_dom.php';
	$html = file_get_html($url);
	foreach ($html->find('div[class=title] a[href]') as $v) {
		$urls[] = $v->href;
		$names[] = $v->plaintext;
	}
	foreach ($html->find('[class=subtle count]') as $k => $v) 
		$objects[] = ["NumberOfSubtitle" => ($v->plaintext), "Name" => $names[$k], "Url" => $urls[$k]];
	echo json_encode($objects, JSON_UNESCAPED_UNICODE);
}catch(Throwable $e){
}
