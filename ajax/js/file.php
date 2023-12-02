<?
$d = array();
foreach($_FILES as $k=>$v)$d[] = $s->addfile($v);
$x .= '$.endfile('.json_encode($d).');';
?>