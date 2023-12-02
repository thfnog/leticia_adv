<?php
if($s->tipoAdm==3)$s->loc('admin');
//if($s->tipoAdm==2)$s->loc('admin');
$rs = $b->query("select id,h1 n from blog where id='{$s->id}' limit 1")->fetchObject();

$s->titpg = 'Recortar '.$rs->n;
$s->titpg3 = 'Recortar Blogs';
