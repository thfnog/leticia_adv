<?php
if($s->tipoAdm==3)$s->loc('admin');
$s->back = 'admin/sabores';
if($s->id&&!($rs=$b->query("select * from sabor where id={$s->id} limit 1")->fetchObject()))$s->loc($s->back);

$s->titpg = 'Sabores';
$s->titpg2 = 'Sabores';
$s->titpg3 = $rs->n?$rs->n:'Novo Sabor';

$a->id = $s->id;
$a->back = $s->back;