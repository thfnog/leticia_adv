<?php
if($s->tipoAdm==3)$s->loc('admin');
//if($s->tipoAdm==2)$s->loc('admin');
if($s->id&&!($rs=$b->query("select * from cat where id={$s->id} limit 1")->fetchObject()))$s->loc($s->back);

$s->titpg = 'Categorias';
$s->titpg2 = 'Categorias';
$s->titpg3 = $rs->n?$rs->n:'Nova Categoria';

$url_seo = $s->base.'produtos/categoria/'.$rs->t;

$a->id = $s->id;
$a->back = $s->back;