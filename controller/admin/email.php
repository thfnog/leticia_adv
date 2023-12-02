<?php
if($s->tipoAdm==3)$s->loc('admin');
//if($s->tipoAdm==2)$s->loc('admin');
if($s->id&&!($rs=$b->query("select * from email where id={$s->id} limit 1")->fetchObject()))$s->loc($s->back);

$s->titpg = 'E-mail';
$s->titpg2 = 'E-mail';
$s->titpg3 = $rs->n?$rs->n:'Novo E-mail';

$a->id = $s->id;
$a->idg = $rs->idg;

$a->gru = array(array('-- Grupo --',0));
$sc = $b->query('select * from grupo order by t');
while($rc=$sc->fetchObject())$a->gru[] = array($rc->n,$rc->id+0);