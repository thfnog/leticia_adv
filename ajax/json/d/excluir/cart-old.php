<?
$id = strp('id',3);
if($s->idc){
	$rc = $b->query("select idc from cart_ax where id=$id limit 1")->fetchObject();
	$rp = $b->query("select * from cart where idu='{$s->idc}' and s=1 and id='{$rc->idc}' limit 1")->fetchObject();
	$b->exec("delete from cart_ax where id=$id limit 1");
	$rt = $b->query("select sum(t) as tot ,count(*) as qp,sum(q) as qtd,sum(w) as peso from cart_ax where idc={$rp->id}")->fetchObject();
	$q = --$rp->i;
	$tot = $rt->tot?$rt->tot:'';
	$vtot = $rt->tot+$rp->f;

	if($tot)$b->exec("update cart set v='$tot',t='$vtot',da=now(),i='{$rt->qp}',q='{$rt->qtd}',w='{$rt->peso}' where id={$rp->id}");
	else{
		if($rp->editando==1)$b->exec("update cart set v=0,t=0,da=now(),i=0,q=0,w=0,f=0,imposto=0 where id={$rp->id}");
		else $b->exec("delete from cart where id={$rp->id} limit 1");
	}
	$x->m = 'Produto removido do <a href="carrinho">carrinho</a> com sucesso!';
	$x->ok = 1;
	$x->q = $q;
	$x->tot = nreal($rt->tot);
	$x->vtot = nreal($vtot);
	$x->peso = $rt->peso;
	$x->des = nreal($des);
}else{
	$ck = $_SESSION["cookie_cart"];
	$rc = $b->query("select idc from cart_ax_temp where id=$id limit 1")->fetchObject();
	$rp = $b->query("select * from cart_temp where cookie='$ck' and s=1 and id='{$rc->idc}' limit 1")->fetchObject();
	$b->exec("delete from cart_ax_temp where id=$id limit 1");
	$rt = $b->query("select sum(t) as tot,count(*) as qp,sum(q) as qtd,sum(w) as peso from cart_ax_temp where idc={$rp->id}")->fetchObject();
	$q = --$rp->i;
	$tot = $rt->tot?$rt->tot:'';
	$vtot = $rt->tot+$rp->f;
	if($tot)$b->exec("update cart_temp set v='$tot',t='$tot',da=now(),i='{$rt->qp}',q='{$rt->qtd}',w='{$rt->peso}' where id={$rp->id}");
	else $b->exec("delete from cart_temp where id={$rp->id} limit 1");
	$x->m = 'Produto removido do <a href="carrinho">carrinho</a> com sucesso!';
	$x->ok = 1;
	$x->q = $q;
	$x->tot = nreal($rt->tot);
	$x->vtot = nreal($rt->tot+$rp->f);
	$x->peso = $rt->peso;
}
?>