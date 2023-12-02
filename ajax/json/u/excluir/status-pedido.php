<?php
if($s->adm()){
	$id = strp('id',3);
	$a = strp('statusPedido',3);

	if($rs=$b->query("select statusPedido,da,devolvido from pedido where id=$id limit 1")->fetchObject()){
		$x->statusPedido = $S = $rs->statusPedido+0;
		$x->da = $rs->da?datef($rs->da,9):'';
	}

	if(!$rs)$x->m = 'Este Pedido não existe!';
	elseif($S==$a)$x->m = 'Nenhum dado para alterar!';
	elseif(!$a)$x->m = 'Escolha o status do Pagamento!';
	elseif(!array_key_exists($a,$s->ps->sttPedido))$x->m = 'Status do Pedido inválido!';
	else{
		if($b->exec("update pedido set statusPedido=$a,da=now() where id=$id limit 1")){
			$x->ok = 1;
			if($a>7&&!$rs->devolvido){
				$sa = $b->query("select * from pedido_ax where idc=$id limit 1");
				while($ra=$sa->fetchObject()){
					$id_produto = $ra->idp;
					$qtd = $ra->q;
					$sql2 = "update produto set estoque=(estoque+$qtd) where id=$id_produto limit 1";
					if($b->exec($sql2))Logger("Pedido devolvido e estoque atualizado com sucesso!");
					else Logger("Nenhum dado para alterar ou erro na atualização!");
				}
				$b->query("update pedido set devolvido=1 where id=$id limit 1");
			}
			if($rs=$b->query("select statusPedido,da from pedido where id=$id limit 1")->fetchObject()){
				$x->statusPedido = $rs->statusPedido+0;
				$x->da = $rs->da?datef($rs->da,9):'';
			}
			$x->status = $status = $s->ps->sttPedido[$a];
			require_once('class/email-status.php');
			//$x->m = 'Status alterado com sucesso!';
		}else $x->m = 'Ação negada!';
	}
}else $neg = true;