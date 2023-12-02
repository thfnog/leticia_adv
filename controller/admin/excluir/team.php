<?php
if($s->tipoAdm==3)$s->loc('admin');
//if($s->tipoAdm==2)$s->loc('admin');
if($s->id&&!($rs=$b->query("select * from team where id={$s->id} limit 1")->fetchObject()))$s->loc($s->back);

$s->titpg = 'Team Sharkpro';
$s->titpg2 = 'Team Sharkpro';
$s->titpg3 = $rs->n?$rs->n:'Novo Membro';

$a->id = $s->id;
$a->back = $s->back;