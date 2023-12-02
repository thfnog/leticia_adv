<?php
if($s->tipoAdm==3||$s->tipoAdm==2)$s->loc('admin');
if(!$s->id)$s->loc($s->back);
if($s->id&&!($rs=$b->query("select * from cart where id={$s->id} and s=1 limit 1")->fetchObject()))$s->loc($s->back);

$s->titpg = 'Carrinhos Abertos';
$s->titpg2 = 'Carrinhos Abertos';
$s->titpg3 = 'Carrinho Aberto';

$a->back = $s->back;