<?php
if($s->tipoAdm==3)$s->loc('admin');
//if($s->tipoAdm==2)$s->loc('admin');
$s->id = 1;
if(!($rs=$b->query("select * from categoria_home where id={$s->id} limit 1")->fetchObject()))$s->loc('admin');

$s->titpg = 'Categorias da Home';
$s->titpg2 = 'Categorias da Home';

$a->id = $s->id;
$a->idc = $rs->idc;
$a->idc2 = $rs->idc2;
$a->idc3 = $rs->idc3;

$P = 'upload/categorias/';
$a->i->i = $rs->i?$P.$rs->i:'';
$a->i->i2 = $rs->i2?$P.$rs->i2:'';
$a->i->i3 = $rs->i3?$P.$rs->i3:'';

$a->cat = array(array('-- Selecione a Categoria --',0));
$sc = $b->query("select id,h1 from cat order by t");
while($rc=$sc->fetchObject())$a->cat[] = array($rc->h1,$rc->id+0);