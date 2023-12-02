<?php
if($s->tipoAdm==2)$s->loc('admin');
$s->lay = 'blank';
$id = $s->id;
require_once 'class/bootstrap-sigep.php';


$rs = $b->query("select * from pedido where id=$id limit 1")->fetchObject();
$forma = tag($s->ps->envio[$rs->tf+0],1);
$codigoRastreio = '';
$etiquetaSemDv = '';

if(!$rs)$s->loc("admin/pedidos");
elseif($rs->statusPedido<3||$rs->statusPedido>6)$s->loc("admin/pedido/$id");