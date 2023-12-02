<?php
if($s->tipoAdm==3||$s->tipoAdm==2)$s->loc('admin');
if($s->id&&!($rs=$b->query("select * from parceiro where id={$s->id} limit 1")->fetchObject()))$s->loc($s->back);

$s->titpg = 'Parceiros';
$s->titpg2 = 'Parceiros';
$s->titpg3 = $rs->n?$rs->n:'Novo Parceiro';

$a->id = $s->id;
$P = 'upload/parceiros/';
$Pt = $P.'thumb/';
$a->i->i = $rs->i?$P.$rs->i:'';
$a->i->it = $rs->it?$Pt.$rs->it:'';

$a->back = $s->back;