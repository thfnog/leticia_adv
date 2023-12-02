<?php
if($s->tipoAdm==3||$s->tipoAdm==2)$s->loc('admin');
$s->back = 'admin/revendedores';
if(!$s->id)$s->loc($s->back);
if($s->id&&!($rs=$b->query("select * from revenda where id={$s->id} limit 1")->fetchObject()))$s->loc($s->back);

$s->titpg = 'Revendedores';
$s->titpg2 = 'Revendedores';
$s->titpg3 = $rs->n;

$a->id = $s->id;

$a->back = $s->back;