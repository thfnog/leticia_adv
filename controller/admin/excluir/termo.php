<?php
if($s->tipoAdm==3||$s->tipoAdm==2)$s->loc('admin');
$s->id = 1;
$rs = $b->query("select * from termos where id={$s->id} limit 1")->fetchObject();

$s->titpg = 'Política do Site';
$s->titpg2 = 'Política do Site';

$a->id = $s->id;

if($s->id)$url_seo = $s->base.'politica-do-site';
