<?php
if($s->tipoAdm==3||$s->tipoAdm==2)$s->loc('admin');
$s->id = 1;
$rs = $b->query("select * from codigo_externo where id={$s->id} limit 1")->fetchObject();

$s->titpg = 'Códigos Externos';
$s->titpg2 = 'Códigos Externos';

$a->id = $s->id;