<?php
$id = strp('id',3);
$idc = $s->idc;

$rs = $b->query("select * from lista_desejo where idp=$id and idc=$idc limit 1")->fetchObject();

if(!$id)$x->m = "Selecione o produto!";
elseif(!$idc)$x->m = "Você precisa estar logado para adicionar um produto a <a href='lista-de-desejo'>lista de desejo</a>!";
elseif($idc&&$rs)$x->m = "Este produto já está na sua <a href='lista-de-desejo'>lista de desejo</a>!";
else{
	if($b->exec("insert into lista_desejo (idp,idc,dc) values ($id,$idc,now())")){
		$st = $b->query("select * from lista_desejo where idc=$idc");
		$x->ok = 1;
		$x->q = '<i class="fa fa-list-alt" style="margin-right:6px;"></i>Lista de desejo ('.$st->rowCount().')';
		$x->q2 = 'Lista de desejo ('.$st->rowCount().')';
		$x->qt = $st->rowCount();
		$x->m = "Produto adicionado a <a href='lista-de-desejo'>lista de desejo</a>!";
		$rp = $b->query("select h1 from produto where id=$id limit 1")->fetchObject();
		$n = addslashes($rp->h1);
		$x->n = "'$n'";
	}else $x->m = "Erro ao adicionar produto a <a href='lista-de-desejo'>lista de desejo</a>!";
}