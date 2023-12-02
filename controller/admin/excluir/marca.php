<?php
if($s->tipoAdm==3)$s->loc('admin');
//if($s->tipoAdm==2)$s->loc('admin');
if($s->id&&!($rs=$b->query("select * from marca where id={$s->id} limit 1")->fetchObject()))$s->loc($s->back);

$s->titpg = 'Marcas';
$s->titpg2 = 'Marcas';
$s->titpg3 = $rs->n?$rs->n:'Nova Marca';

$url_seo = $s->base.'produtos/marca/'.$rs->t;

$a->id = $s->id;
$a->back = $s->back;