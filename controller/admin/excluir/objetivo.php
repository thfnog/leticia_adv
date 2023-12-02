<?php
if($s->tipoAdm==3)$s->loc('admin');
//if($s->tipoAdm==2)$s->loc('admin');
if($s->id&&!($rs=$b->query("select * from objetivo where id={$s->id} limit 1")->fetchObject()))$s->loc($s->back);

$s->titpg = 'Objetivos';
$s->titpg2 = 'Objetivos';
$s->titpg3 = $rs->n?$rs->n:'Novo Objetivo';

$a->id = $s->id;
$P = 'upload/objetivos/';
$Pt = $P.'thumb/';
$a->i->i = $rs->i?$P.$rs->i:'';
$a->i->it = $rs->it?$Pt.$rs->it:'';

if($s->id)$url_seo = $s->base.(substr($rs->tipo,0,-1)).'/'.$s->id.'/'.$rs->t;

$a->back = $s->back;