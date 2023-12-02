<?php
require_once "class/erede/Classloader.php";
use erede\model\EnvironmentType;
use erede\model\RefundRequest;
use erede\model\UrlRequest;
use erede\model\UrlKind;

if(true){
	$id = strp('id',3);
	$tid = strps('tid');
	$rs = $b->query($x->ue="select * from pedido where id=$id and tid='$tid' and idu='{$s->idc}' limit 1")->fetchObject();
	
	if(!$s->idc)$x->m = 'Você precisa estar logado!';
	elseif(!$id)$x->m = 'Pedido inválido!';
	elseif(!$tid)$x->m = 'TID inválido!';
	elseif($cancelado=$b->query("select refundId from pedido where id=$id and tid='$tid' and idu='{$s->idc}' and refundId is not null limit 1")->fetchObject())$x->m = "Pedido já foi cancelado o id do cancelamento é $cancelado->refundId";
	elseif(!$rs||$rs->statusPedido!=1)$x->m = 'Você não pode cancelar esse pedido!';
	else{
		$total = str_replace(array('.', ','),"",$rs->t);
		$pv = '10000435';//SANDBOX
		$token = 'b74b1b812e7141cb98b11e60764caaa8';//SANDBOX
		$pv = '75867664';
		$token = '354220e0e6ca4277822db0592f2a8505';
		try{
			$refundRequest = new RefundRequest();
			$refundRequest->setAmount($total);
			$urls = array();
			$urlCallback = new UrlRequest();
			$urlCallback->setKind(UrlKind::CALLBACK);
			$urlCallback->setUrl("{$s->dom}{$s->dir}ajax/u/cancelar.json");
			$urls[] = $urlCallback;
			$refundRequest->setUrls($urls);
			
			$acquirer = new Acquirer($pv,$token, EnvironmentType::PRODUCTION);
			//$acquirer = new Acquirer($pv,$token, EnvironmentType::HOMOLOG);
			$x->RequestJSON = $refundRequest->toJson();
			$response = $acquirer->refund($tid, $refundRequest);
			$x->ResponseJSON = $response->toJson();
			$x->RefundId = $refundId = $response->getRefundId();
			if($refundId){
				$b->exec("update pedido set refundId='$refundId',cancelado=1,statusPedido=9 where id=$id limit 1");
				$x->ok = 1;
				$x->m = "Pedido cancelado com sucesso o ID de cancelamento é: $refundId";
			}else{
				$x->ok = 0;
				$x->m = 'Erro ao cancelar pedido!';
			}
		}catch(Exception $e){
			$x->ok = 0;
			$x->caughtException = $e->getMessage();
		}
	}
}else $neg = true;
?>