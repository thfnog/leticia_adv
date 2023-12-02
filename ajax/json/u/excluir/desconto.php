<?php
$id = strp('id',3);
$idc = $s->idc;
$c = strpr('c');
$hj = date("Y-m-d");
$x->ok = 0;

$ru = $b->query("select * from cupom where c='$c' limit 1")->fetchObject();
$rc = $b->query("select * from cart where idu='{$s->idc}' and id=$id limit 1")->fetchObject();
$rm = $b->query("select count(idd) as q from pedido where idu='{$s->idc}' and idd='{$ru->id}'")->fetchObject();

if($ru->tipo_cupom=='produto'){
	$cupom = $b->query("select sum(t) t from (select a.t t from cart_ax a left join cart c on a.idc=c.id left join cupom_ax u on a.idp=u.idp where a.idc='{$rc->id}' and u.idc='{$ru->id}' group by a.idp) t1")->fetchObject();
}elseif($ru->tipo_cupom=='produtos'){
	$cupom = $b->query("select sum(t) t from(select a.t t from cart_ax a left join cart c on a.idc=c.id left join cupom u on c.idd=u.id where a.idc='{$rc->id}' group by a.idp) t1")->fetchObject();
}elseif($ru->tipo_cupom=='categoria'){
	$cupom = $b->query("select sum(t) t from (select a.t t from cart_ax a left join cart c on a.idc=c.id left join produto p on a.idp=p.id left join cat ca on p.idc=ca.id or p.idc2=ca.id left join cupom_ax u on ca.id=u.ida where a.idc='{$rc->id}' and u.idc='{$ru->id}' group by a.idp) t1")->fetchObject();
}

if(!$s->idc)$x->m = 'Você precisa estar logado para usar o cupom de desconto!';
elseif(!$ru)$x->m = 'O cupom é inválido!';
elseif($rc->v<$ru->v)$x->m = "Para usar este cupom!\nO valor do pedido precisa de ser ao menos R$ {$ru->v}!";
elseif($ru->dv<$hj)$x->m = 'O cupom expirou, atingiu seu limite de uso!';
elseif($ru->q<=$ru->u)$x->m = 'O cupom atingiu seu limite de uso!';
elseif($rc->idd==$ru->id)$x->m = 'Este cupom já está sendo usado nesse carrinho!';
elseif($rm->q>=$ru->l)$x->m = 'Você já utilizou este cupom!';
elseif(!$cupom->t=='NULL')$x->m = 'Os produtos que estão no carrinho não fazem parte deste cupom de desconto!';
else{
	if($ru->tipo_desconto=='porcentagem'){
		$des = ($cupom->t*$ru->dp)/100;
		$tot = $rc->v - $des;
	}else{
		if($ru->df>$cupom->t)$des = $cupom->t;
		else $des = $ru->df;
		$tot = $rc->v - $des;
	}

	if($ru->tipo_desconto=='porcentagem')$b->query("update cart set idd='{$ru->id}',vd='$des',dp='$des',df=0,da=now() where id=$id limit 1");
	else $b->query("update cart set idd='{$ru->id}',vd='$des',df='$des',dp=0,da=now() where id=$id limit 1");
	$x->m = 'Cupom utilizado com sucesso!';
	$x->ok = 1;
	$x->c = $c;
	$x->desconto = nreal($des);
	$x->vtot = nreal($tot);
}