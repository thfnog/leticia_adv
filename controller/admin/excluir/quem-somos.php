<?php
if($s->tipoAdm==3||$s->tipoAdm==2)$s->loc('admin');
$s->id = 1;
$rs = $b->query("select * from empresa where id={$s->id} limit 1")->fetchObject();

$s->titpg = 'Quem Somos';
$s->titpg2 = 'Quem Somos';

$a->id = $s->id;

if($s->id)$url_seo = $s->base.'/quem-somos';
