<?
if($s->adm()){
	$id = strp('id',3);
	$a = strp('s',3);
	$p = strp('p',3);

	if($rs=$b->query("select a,p,da from cart where id=$id limit 1")->fetchObject()){
		$x->s = $S = $rs->a+0;
		$x->p = $P = $rs->p+0;
		$x->da = $rs->da?datef($rs->da,9):'';
	}

	if(!$rs)$x->m = 'Este Pedido não existe!';
	elseif($S==$a&&$P==$p)$x->m = 'Nenhum dado para alterar!';
	elseif(!$s&&!$p)$x->m = 'Escolha o status do Pedido ou o status do Pagamento!';
	elseif(!$s&&$P==$p)$x->m = 'Escolha o status do Pagamento!';
	elseif(!$p&&$S==$a)$x->m = 'Escolha o status do Pedido!';
	elseif(!array_key_exists($a,$s->ps->stt))$x->m = 'Status do Pagamento inválido!';
	elseif(!array_key_exists($p,$s->ps->sttPedido))$x->m = 'Status do Pedido inválido!';
	//elseif($S==5&&$p==5)$x->m = 'O pagamento está em disputa, você não pode alterar o status para Enviando enquanto a disputa não for resolvida!';
	//elseif($S==6&&$p==5)$x->m = 'O pagamento foi devolvido para o cliente, o pedido foi cancelado!';
	elseif($a==3&&$p<5&&$P!=$p)$x->m = 'O pagamento foi cancelado, você não pode alterar o status do pedido, pois ele foi cancelado!';
	elseif($a==3&&$p==5&&$P!=$p)$x->m = 'O pagamento foi cancelado, você não pode alterar o status para Enviando!';
	else{
		if($b->exec("update cart set a=$a,p=$p where id=$id limit 1")){
			$b->exec("update cart set da=now() where id=$id limit 1");
			$x->ok = 1;
			if($rs=$b->query("select a,p,da from cart where id=$id limit 1")->fetchObject()){
				$x->s = $rs->a+0;
				$x->p = $rs->p+0;
				$x->da = $rs->da?datef($rs->da,9):'';
			}
			//$x->m = 'Status alterado com sucesso!';
		}else $x->m = 'Ação negada!';
	}
}else $neg = true;
?>