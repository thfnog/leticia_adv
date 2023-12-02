<?php
$id = strp('id',3);
$idc = strp('idc',3);

if(!$id)$x->m = 'Este pedido não existe!';
elseif(!$idc)$x->m = 'Você precisa estar logado para cancelar o pedido!';
elseif(!$rs=$b->query("select * from pedido where id=$id and idu='{$s->idc}' limit 1")->fetchObject())$x->m = 'Você não pode cancelar esse pedido!';
elseif($rs->statusPedido==9)$x->m = 'Este pedido já está cancelado!';
else{
	$data = array();
	require_once('class/pagHiper.php');
	$AMBIENTE = 'production';
	$FORMA = $s->formasPagamento('paghiper',$AMBIENTE);

	$data = array();
	$data['token'] = $FORMA->token;
	$data['apiKey'] = $FORMA->paghiperApiKey;
	$data['status'] = 'canceled';
	$data['transaction_id'] = $rs->transactionID;
	$result = $PAGHIPER->cancelarBoleto($data);
	$x->code = $result['cancellation_request']['http_code'];
	$x->m = $result['cancellation_request']['response_message'];
	if($x->code==201){
		$b->query("update pedido set statusPedido=9 where id=$id limit 1");
		$x->ok = 1;
	}
}