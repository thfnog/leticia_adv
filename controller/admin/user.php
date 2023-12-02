<?php
if($s->tipoAdm==3||$s->tipoAdm==2)$s->loc('admin');
if($s->id&&!($rs=$b->query("select * from user where id={$s->id} and t!=5 limit 1")->fetchObject()))$s->loc($s->back);

$s->titpg = 'Usuário';
$s->titpg2 = 'Usuário';
$s->titpg3 = $rs->n?$rs->n:'Novo Usuário';

$s->id==2?$s->loc('admin/users'):'';

$a->id = $s->id;
$P = 'upload/users/';
$Pt = $P.'thumb/';
$a->i->i = $rs->i?$P.$rs->i:'';
$a->t = $rs->t+0;

$a->back = $s->back;