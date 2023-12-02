<?
$b->query("update cliente set cookie=NULL where id='{$s->idc}' limit 1");
$s->logout('.');
?>