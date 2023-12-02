<?php
if($s->tipoAdm==2)$s->loc('admin');
if($s->id&&!($rs=$b->query("select * from pedido where id={$s->id} limit 1")->fetchObject()))$s->loc($s->back);

$s->titpg = 'Pedidos';
$s->titpg2 = 'Pedido';

if($s->id){
	$a->id = $s->id;
	$a->statusPagseguro = $rs->statusPagseguro+0;
	$a->statusPedido = $rs->statusPedido+0;
	$a->da = $rs->da?datef($rs->da,9):'';
}

$a->back = $s->back;