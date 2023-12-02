<?php
include 'class/main.php';
// ----- ----- //


$neg = false;

$gmtDate = gmdate('D, d M Y H:i:s');
header("Expires: $gmtDate GMT");
header("Last-Modified: $gmtDate GMT");
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

if($s->cat&&file_exists($___f="{$s->AJAX}{$s->cat}.php")){
	include $___f;
}

if($s->cat&&$s->act&&file_exists($___f="{$s->AJAX}{$s->cat}/{$s->act}.php")){
	include $___f;
}

if($s->cat&&$s->act&&$s->pg&&file_exists($___f="{$s->AJAX}{$s->cat}/{$s->act}/{$s->pg}.php")){
	include $___f;
}

if($s->cat&&$s->act&&$s->pg&&$s->spg&&file_exists($___f="{$s->AJAX}{$s->cat}/{$s->act}/{$s->pg}/{$s->spg}.php")){
	include $___f;
}

if($s->cat&&file_exists($___f="{$s->AJAX}{$s->cat}.o.php")){
	include $___f;
}



exit;