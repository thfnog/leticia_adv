<?php
if($s->tipoAdm==3||$s->tipoAdm==2)$s->loc('admin');
$s->id = 3;
$rs = $b->query("select * from termos where id={$s->id} limit 1")->fetchObject();

$s->titpg = 'Prazos e Formas de Entrega';
$s->titpg2 = 'Prazos e Formas de Entrega';

$a->id = $s->id;

if($s->id)$url_seo = $s->base.'/prazos-e-formas-de-entrega';
