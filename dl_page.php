<?php
require 'html_dom.php';
require 'jsonhandler.php';
require 'find_server.php';
if (!isset($_GET['url'])) die();
$url=htmlentities($_GET['url']);
$html = file_get_html($server.$url);
$releaseinfo=$html->find('[class=release]',0)->plaintext;
$dllink='?mac='.$html->find('a[id=downloadButton]',0)->href;
while(strpos($releaseinfo, "\t\t") !== false) {
    $releaseinfo=str_replace("\t\t", '', $releaseinfo);
}
$z=new ZJson([$releaseinfo,$dllink]);
echo $z->SerializeObject();