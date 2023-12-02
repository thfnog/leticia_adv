<?php
$id = strp('id',3);
$qt = strp('qt',3);
if($qt&&$qt<1)$qt = 1;
$hj = date("Y-m-d");

if(is_int($qt))$qt = array($id=>$qt);
if(is_array($qt)){
	if($s->idc&&$s->tipo==3){
		foreach($qt as $k=>$v){
			$k = (int)$k;
			$v = (int)$v;
			$sp = $b->query("select * from cart where idu='{$s->idc}' and s=1 order by id desc");
			$rp = $sp->fetchObject();
			$rq = $b->query("select peso w,v,c cod from produto where id=$k limit 1")->fetchObject();
			$cod = addslashes($rq->cod);
			$preco_prod = $rq->v;
			
			if(!$v)$x->m = "Selecione a quantidade!";
			//elseif($rq->estoque<=0&&$rq->controlaestoque=='S')$x->m = "Produto indisponível!";
			//elseif($v>$rq->estoque&&$rq->controlaestoque=='S')$x->m = 'No momento temos apenas '.$rq->estoque.' unidade'.($rq->estoque>1?'s':'').' em nosso estoque!';
			elseif((!$sp->rowCount()||$rp->s==1)||($sp->rowCount()&&$rp->s==2)){
				$rc = $b->query("select *,rua,cep,city,num,bairro,uf,comp from cliente where id='{$s->idc}'")->fetchObject();
				if(!$sp->rowCount()||$rp->s==2){
					$cli_n = addslashes($rc->n?$rc->n:$rc->r);
					$cli_rua = addslashes($rc->rua);
					$cli_num = addslashes($rc->num);
					$cli_comp = addslashes($rc->comp);
					$cli_bairro = addslashes($rc->bairro);
					$cli_cep = addslashes($rc->cep);
					$cli_city = addslashes($rc->city);
					$cli_uf = addslashes($rc->uf);
					$cli_t1 = addslashes($rc->t1);
					$b->exec("insert into cart set dc=now(),idu='{$s->idc}',q=1,n='$cli_n',rua='$cli_rua',num='$cli_num',comp='$cli_comp',bairro='$cli_bairro',cep='$cli_cep',city='$cli_city',uf='$cli_uf',t1='$cli_t1'");
					$id = $b->lastInsertId();
				}
				if($sp->rowCount()&&$rp->s==1)$id=$rp->id;
				if($id){
					$ra = $b->query("select * from cart_ax where idp=$k and idc=$id limit 1")->fetchObject();
					if($v&&$ra->idp==$k)$x->m = 'Erro: Produto já adicionado no carrinho, se deseja alterar a quantidade vá para a página do <a href="carrinho">carrinho</a>!';
					elseif($v){
						$prod = $b->query("select id,h1 n,t from produto where id=$k limit 1")->fetchObject();
						$peso = $v * $rq->w;
						$total = $v * $preco_prod;
						if($b->exec("insert into cart_ax set idc=$id,idp=$k,q=$v,v='$preco_prod',t='$total',p='$rq->w',w='$peso',pc='$cod'"))$ida = $b->lastInsertId();
						$rt = $b->query("select sum(t) as tot,count(*) as qp,sum(q) as qtd,sum(w) as peso from cart_ax where idc=$id")->fetchObject();
						$q = $rt->qp;		

						$vtot = $rt->tot;

						$rp = $b->query("select * from cart where idu='{$s->idc}' and id=$id limit 1")->fetchObject();
						$b->exec($x->ups="update cart set da=now(),v='{$rt->tot}',t='{$rt->tot}',i='{$rt->qp}',q='{$rt->qtd}',w='{$rt->peso}' where id=$id");
						$x->m = 'Sucesso: Você adicionou <a href="produto/'.$prod->id.'/'.$prod->t.'">'.$prod->n.'</a> ao <a href="carrinho">carrinho</a>!';
						$x->ok = 1;
						$x->q = $q;
						$x->tot = nreal($rt->tot);
						$x->vtot = nreal($vtot);
						$x->peso = $rt->peso;
						$x->ida = $ida;
						$rface = $b->query("select h1 n,v from produto where id=$k limit 1")->fetchObject();
						$face_n = addslashes($rface->n);
						//$face_cn = addslashes($rface->cn);//SE TVER CATEGORIA
						$face_val = $rface->v;
						$x->n = "'$face_n'";
						$x->cn = "'$face_cn'";
						$x->v = number_format($face_val,2,'.','');
					}
				}
			}
		}
	}else{
		foreach($qt as $k=>$v){
			$k = (int)$k;
			$v = (int)$v;
			$ck = $_SESSION['cookie_cart'];
			$sp = $b->query("select * from cart_temp where cookie='$ck' order by id desc");
			$rp = $sp->fetchObject();
			$rq = $b->query("select peso w,v,c cod from produto where id=$k limit 1")->fetchObject();
			$cod = addslashes($rq->cod);
			$preco_prod = $rq->v;
			
			if(!$v)$x->m = "Selecione a quantidade!";
			//elseif($rq->estoque<=0&&$rq->controlaestoque=='S')$x->m = "Produto indisponível!";
			//elseif($v>$rq->estoque&&$rq->controlaestoque=='S')$x->m = 'No momento temos apenas '.$rq->estoque.' unidade'.($rq->estoque>1?'s':'').' em nosso estoque!';
			elseif((!$sp->rowCount()||$rp->s==1)||($sp->rowCount()&&$rp->s==2)){
				if(!$sp->rowCount()||$rp->s==2){
					$b->exec("insert into cart_temp set dc=now(),cookie='$ck',q=1");
					$id = $b->lastInsertId();
				}
				if($sp->rowCount()&&$rp->s==1)$id=$rp->id;
				if($id){
					$ra = $b->query("select * from cart_ax_temp where idp=$k and idc=$id limit 1")->fetchObject();
					if($v&&$ra->idp==$k)$x->m = 'Erro: Produto já adicionado no carrinho, se deseja alterar a quantidade vá para a página do <a href="carrinho">carrinho</a>!';
					elseif($v){
						$prod = $b->query("select id,h1 n,t from produto where id=$k limit 1")->fetchObject();
						$peso = $v * $rq->w;
						$total = $v * $preco_prod;
						if($b->exec("insert into cart_ax_temp set idc=$id,idp=$k,q=$v,v='$preco_prod',t='$total',p='$rq->w',w='$peso',pc='$cod'"))$ida = $b->lastInsertId();
						$rt = $b->query("select sum(t) as tot,count(*) as qp,sum(q) as qtd,sum(w) as peso from cart_ax_temp where idc=$id")->fetchObject();
						$q = $rt->qp;		

						$vtot = $rt->tot;

						$b->exec("update cart_temp set da=now(),v='{$rt->tot}',t='{$rt->tot}',i='{$rt->qp}',q='{$rt->qtd}',w='{$rt->peso}' where id=$id");
						$x->m = 'Sucesso: Você adicionou <a href="produto/'.$prod->id.'/'.$prod->t.'">'.$prod->n.'</a> ao <a href="carrinho">carrinho</a>!';
						$x->ok = 1;
						$x->q = $q;
						$x->tot = nreal($rt->tot);
						$x->vtot = nreal($vtot);
						$x->peso = $rt->peso;
						$x->ida = $ida;
						$rface = $b->query("select h1 n,v from produto where id=$k limit 1")->fetchObject();
						$face_n = addslashes($rface->n);
						//$face_cn = addslashes($rface->cn);//SE TVER CATEGORIA
						$face_val = $rface->v;
						$x->n = "'$face_n'";
						$x->cn = "'$face_cn'";
						$x->v = number_format($face_val,2,'.','');
					}
				}
			}
		}
	}
}