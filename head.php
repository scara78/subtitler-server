<?php
$server = "http://subscene.com";
// ini_set('memory_limit', '256M');
ini_set('allow_url_fopen', 1);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

if (isset($_GET['lang'])) {
	$slang = [
		"English", "Farsi/Persian", "Arabic", "Brazillian Portuguese", "Danish", "Dutch",
		"Finnish", "French", "Hebrew", "Indonesian", "Italian", "Norwegian", "Romanian", "Spanish",
		"Swedish", "Vietnamese", "Hindi", "Russian"
	];
	$lang = $slang[$_GET['lang']];
}
