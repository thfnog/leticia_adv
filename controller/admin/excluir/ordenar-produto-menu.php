<?php
if($s->tipoAdm==3)$s->loc('admin');
//if($s->tipoAdm==2)$s->loc('admin');
$s->titpg = 'Ordenar Produtos do Menu';
$s->titpg2 = 'Ordenar Produtos do Menu';

$a->cat = array(array('-- Categoria --',0));

$sc = $b->query("select id,h1 n from cat where s order by t");
while($rc=$sc->fetchObject())$a->cat[] = array($rc->n,$rc->id+0);
