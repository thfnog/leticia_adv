<?php
if($s->tipoAdm==3||$s->tipoAdm==2)$s->loc('admin');
$s->id = 1;
$rs = $b->query("select * from dados where id={$s->id} limit 1")->fetchObject();

$s->titpg = 'Informações de Frete e Boleto';
$s->titpg2 = 'Informações de Frete e Boleto';

$a->id = $s->id;