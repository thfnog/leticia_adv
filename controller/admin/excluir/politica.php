<?php
if($s->tipoAdm==3||$s->tipoAdm==2)$s->loc('admin');
$s->id = 2;
$rs = $b->query("select * from termos where id={$s->id} limit 1")->fetchObject();

$s->titpg = 'Politica de Devolução';
$s->titpg2 = 'Politica de Devolução';

$a->id = $s->id;

if($s->id)$url_seo = $s->base.'/politica-de-devolucao';
