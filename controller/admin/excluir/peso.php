<?php
if($s->tipoAdm==3)$s->loc('admin');
if($s->id&&!($rs=$b->query("select * from peso where id={$s->id} limit 1")->fetchObject()))$s->loc($s->back);

$s->titpg = 'Pesos';
$s->titpg2 = 'Pesos';
$s->titpg3 = $rs->n?$rs->n:'Novo Peso';

$a->id = $s->id;
$a->back = $s->back;