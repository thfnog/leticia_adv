<?php
if($s->tipoAdm==3||$s->tipoAdm==2)$s->loc('admin');
if($s->adm())$s->loc('admin');

if($s->id){
	$rs = $b->query("select * from user where id='{$s->id}' limit 1")->fetchObject();
	if(!$rs||!$rs->cod)$s->loc('admin/esqueci');
}