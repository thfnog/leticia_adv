<?
$id = strp('id',3);
$qt = strp('qt',3);
if(is_int($qt))$qt = array($id=>$qt);
if(is_array($qt)){
	foreach($qt as $k=>$v){
		$k = (int)$k;
		$v = (int)$v;
		$ck = $_SESSION['cookie_cart'];
		if($s->idc)$sc = $b->query("select * from cart where idu='{$s->idc}' and s=1 order by id desc");
		else $sc = $b->query("select * from cart_temp where cookie='$ck' order by id desc");
		$rc = $sc->fetchObject();
		$rq = $b->query("select peso w,v,c cod from produto where id=$k limit 1")->fetchObject();
		//if($v>$rq->estoque&&$rq->controlaestoque=='S')$x->m = 'No momento temos apenas '.$rq->estoque.' produto'.($rq->estoque>1?'s':'').' em nosso estoque!';
		if((!$sc->rowCount()||$rc->s==1)||($sc->rowCount()&&$rc->s==2)){
			if($id){
				if($v&&$s->idc){
					$ra = $b->query("select * from cart_ax where idp=$k and idc={$rc->id} limit 1")->fetchObject();
					$t = $v*$ra->v;
					$peso = $v * $rq->w;
					$b->exec("update cart_ax set q='$v',t='$t',w='$peso' where id='{$ra->id}'");
					$rt = $b->query("select sum(t) as stot,sum(w) as peso from cart_ax where idc={$rc->id}")->fetchObject();
					$vtot = $rt->stot;

					$b->exec("update cart set v='{$rt->stot}',t='$vtot',w='{$rt->peso}',da=now() where id={$rc->id}");
					$x->ok = 1;
					$x->m = 'Carrinho atualizado com sucesso!';
					$x->t = nreal($t);
					$x->tot = nreal($rt->stot);
					$x->vtot = nreal($vtot);
					$x->peso = $rt->peso;
					$x->des = nreal($des);
				}elseif($v&&!$s->idc){
					$ra = $b->query("select * from cart_ax_temp where idp=$k and idc={$rc->id} limit 1")->fetchObject();
					$t = $v*$ra->v;
					$peso = $v * $rq->w;
					$b->exec($x->upd="update cart_ax_temp set q=$v,t='$t',w='$peso' where id='{$ra->id}'");
					$rt = $b->query("select sum(t) as stot,sum(w) as peso from cart_ax_temp where idc={$rc->id}")->fetchObject();
					$vtot = $rt->stot;
					//$b->exec("update cart_temp set v='{$rt->stot}',t='{$vtot}',w='{$rt->peso}',da=now() where id={$rc->id}");COM SOMA DO FRETE
					$b->exec("update cart_temp set v='{$rt->stot}',t='{$rt->stot}',w='{$rt->peso}',da=now() where id={$rc->id}");
					$x->ok = 1;
					$x->m = 'Carrinho atualizado com sucesso!';
					$x->t = nreal($t);
					$x->tot = nreal($rt->stot);
					$x->vtot = nreal($vtot);
					$x->peso = $rt->peso;
				}
			}
		}
	}
}
?>