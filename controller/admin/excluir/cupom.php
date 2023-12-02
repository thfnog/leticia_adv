<?php
if($s->tipoAdm==3||$s->tipoAdm==2)$s->loc('admin');
if($s->id&&!($rs=$b->query("select * from cupom where id={$s->id} limit 1")->fetchObject()))$s->loc($s->back);

$s->titpg = 'Cupons';
$s->titpg2 = 'Cupons';
$s->titpg3 = $rs->n?$rs->n:'Cupom';

$a->id = $s->id;
$s->back = 'admin/cupons/';

$a->tipo_cupom = $s->id?$rs->tipo_cupom:0;
$a->tipo_desconto = $s->id?$rs->tipo_desconto:0;