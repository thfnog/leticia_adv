<?php
if($s->tipoAdm==3)$s->loc('admin');
//if($s->tipoAdm==2)$s->loc('admin');
if($s->id&&!($rs=$b->query("select * from slider where id={$s->id} limit 1")->fetchObject()))$s->loc($s->back);

$s->titpg = 'Sliders';
$s->titpg2 = 'Sliders';
$s->titpg3 = $rs->n?$rs->n:'Novo Slider';

$a->id = $s->id;
$a->tipo = $rs->tipo;
$P = 'upload/sliders/';
$Pt = $P.'thumb/';
$Pe = $P.'element/';
$a->i->i = $rs->i?$P.$rs->i:'';
$a->i->it = $rs->it?$Pt.$rs->it:'';
$a->i->im = $rs->im?$Pt.$rs->im:'';
$a->i->ie = $rs->ie?$Pe.$rs->ie:'';
$a->i->iet = $rs->iet?$Pe.$rs->iet:'';
$a->i->iem = $rs->iem?$Pe.$rs->iem:'';

$a->back = $s->back;