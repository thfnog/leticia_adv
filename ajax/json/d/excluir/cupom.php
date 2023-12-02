<?
if($s->adm()){
	$id = strp('id',3);
	if($rs=$b->query("select id from cupom where id=$id limit 1")->fetchObject()){
		if($rs=$b->query("select c.id from cupom c left join cart a on c.id=a.idd left join pedido p on c.id=p.idd where a.idd=$id or p.idd=$id limit 1")->fetchObject())$x->m = 'Você não pode excluir este cupom, pois ele está vinculado com um pedido!';
		elseif($b->exec("delete from cupom where id=$id limit 1")){
			$b->exec("delete from cupom_ax where idc=$id");
			$x->m = 'Cupom excluído com sucesso!';
			$x->ok = 1;
		}else $x->m = 'Erro ao excluir o cupom!';
	}else $x->m = 'Cupom não existe!';
}else $neg = true;
?>