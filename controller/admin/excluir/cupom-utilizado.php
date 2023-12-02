<?
if(!$s->id)$s->loc($s->back);
if($s->id&&!($rs=$b->query("select * from cupom where id={$s->id} limit 1")->fetchObject()))$s->loc($s->back);

$s->titpg = 'Cupons';
$s->titpg2 = 'Cupons';
$s->titpg3 = $rs->n?$rs->n:'Cupom';

$a->id = $s->id;
$s->back = 'admin/cupons/';