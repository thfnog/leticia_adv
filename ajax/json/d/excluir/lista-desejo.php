<?php
$id = strp('id',3);
$idc = $s->idc;

$rs = $b->query("select * from lista_desejo where idp=$id and idc=$idc limit 1")->fetchObject();

if(!$id)$x->m = "Selecione o produto!";
elseif(!$idc)$x->m = "Você precisa estar logado para remover um produto da <a href='lista-de-desejo'>lista de desejo</a>!";
elseif(!$rs)$x->m = "Este produto não está na sua <a href='lista-de-desejo'>lista de desejo</a>!";
else{
	if($b->exec("delete from lista_desejo where idp=$id and idc=$idc")){
		$st = $b->query("select * from lista_desejo where idc=$idc");
		$x->ok = 1;
		$x->id = $id;
		$x->q = '<i class="fa fa-list-alt" style="margin-right:6px;"></i>Lista de desejo ('.$st->rowCount().')';
		$x->q2 = 'Lista de desejo ('.$st->rowCount().')';
		$x->qt = $st->rowCount();
		$x->m = "Produto removido da <a href='lista-de-desejo'>lista de desejo</a>!";
		$rp = $b->query("select h1 from produto where id=$id limit 1")->fetchObject();
		$n = addslashes($rp->h1);
		$x->n = "'$n'";
	}else $x->m = "Erro ao remover produto da <a href='lista-de-desejo'>lista de desejo</a>!";
}