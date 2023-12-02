<?php
if($s->tipoAdm==3)$s->loc('admin');
//if($s->tipoAdm==2)$s->loc('admin');
if($s->id&&!($rs=$b->query("select * from blog where id={$s->id} limit 1")->fetchObject()))$s->loc($s->back);

$s->titpg = 'Blogs';
$s->titpg2 = 'Blogs';
$s->titpg3 = $rs->n?$rs->n:'Novo Post';

$a->id = $s->id;

if($s->id)$url_seo = $s->base.'/'.$rs->t;

$a->back = $s->back;