<?php
class cart{
	public function insert($idp=0,$qt,$idc=0,$prefix='',$cookie=''){
		global $b;
		if($prefix){
			$tableCart = "cart$prefix";
			$tableCartAx = "cart_ax$prefix";
			$sp = $b->query("select * from $tableCart where cookie='$cookie' and s=1 order by id desc");
		}else{
			$tableCart = "cart";
			$tableCartAx = "cart_ax";
			$sp = $b->query("select * from $tableCart where idu=$idc and s=1 order by id desc");
		}
		$rq = $b->query("select p.v,p.id,e.adicional,e.estoque from produto p inner join produto_estoque e on p.id=e.id_produto and e.id=$idp limit 1")->fetchObject();
		$preco_prod = $rq->v+$rq->adicional;
		
		if(!$qt)$x->shopping->m = "Selecione a quantidade!";
		elseif($rq->estoque<=0)$x->shopping->m = "Produto indisponível!";
		elseif($qt>$rq->estoque)$x->shopping->m = 'No momento temos apenas '.$rq->estoque.' unidade'.($rq->estoque>1?'s':'').' em nosso estoque!';
		else{
			if(!$sp->rowCount()){
				if($prefix)$b->exec("insert into $tableCart set dc=now(),cookie='$cookie',q=1");
				else $b->exec("insert into $tableCart set dc=now(),idu=$idc,q=1");
				$idc = $b->lastInsertId();
			}
			else{
				$rp = $sp->fetchObject();
				$idc = $rp->id;
			}
			if($idp){
				$ra = $b->query("select * from $tableCartAx where idp=$idp and idc=$idc limit 1")->fetchObject();
				if($qt&&$ra->idp==$idp)$x->shopping->m = 'Erro: Produto já adicionado no carrinho, se deseja alterar a quantidade vá para a página do <a href="carrinho">carrinho</a>!';
				elseif($qt){
					$prod = $b->query("select id,h1 n,t from produto where id='{$rq->id}' limit 1")->fetchObject();
					$opcao = $b->query("select s.n sabor,p.n peso from produto_estoque e inner join sabor s on e.id_sabor=s.id inner join peso p on e.id_peso=p.id where e.id=$idp limit 1")->fetchObject();
					$nomeProduto = $prod->n.' - '.$opcao->sabor.' / '.$opcao->peso;
					$total = $qt * $preco_prod;
					if($b->exec("insert into $tableCartAx set idc=$idc,idp=$idp,q=$qt,v='$preco_prod',t='$total'"))$ida = $b->lastInsertId();

					$rt = $b->query("select sum(t) as tot,count(*) as qp,sum(q) as qtd from $tableCartAx where idc=$idc")->fetchObject();
					$q = $rt->qp;		
					$vtot = $rt->tot;
	
					$b->exec($x->shopping->ups="update $tableCart set da=now(),v='{$rt->tot}',t='$vtot',i='$q',q='{$rt->qtd}' where id=$idc");
					$x->shopping->m = '<span>Sucesso:</span> Você adicionou '.$nomeProduto.' ao <a href="carrinho" class="link-carrinho">Carrinho</a>!';
					$x->shopping->ok = 1;
					$x->shopping->q = $q;
					$x->shopping->qt = $qt;
					$x->shopping->tot = nreal($rt->tot);
					$x->shopping->vtot = nreal($vtot);
					$x->shopping->ida = $ida;
					$x->shopping->idp = $idp;
					$foto = $b->query("select itc from fotos where tipo='produto' and idp=$idp and principal")->fetchObject();
					$x->shopping->produto = '
					<li class="mini_cart_item item-'.$ida.'" data-id="'.$ida.'">
						<a class="remove del-produto">×</a>
						<img src="upload/produtos/thumb/'.($foto->itc?$foto->itc:'default.jpg').'" alt="'.$prod->n.'">
						<p>'.$nomeProduto.'</p>
						<p class="quantity"><input type="number" min="1" value="'.$qt.'" class="cart-qtd" data-qtd-idp="'.$idp.'"> <span class="amount">R$ '.nreal($preco_prod).'</span></p>
					</li>';
				}
			}
		}
		return $x->shopping;
	}
	public function delete($id=0,$idc=0,$prefix='',$cookie=''){
		global $b;
		if($prefix)$rc = $b->query("select a.idc,c.id,c.i from cart_ax$prefix a inner join cart$prefix c on a.idc=c.id where a.id=$id and c.cookie='$cookie' and c.s=1 limit 1")->fetchObject();
		else $rc = $b->query("select a.idc,c.id,c.i,c.f,c.idd from cart_ax a inner join cart c on a.idc=c.id where a.id=$id and c.idu=$idc and c.s=1 limit 1")->fetchObject();
		$b->exec("delete from cart_ax$prefix where id=$id limit 1");
		$rt = $b->query("select sum(t) as tot ,count(*) as qp,sum(q) as qtd,sum(w) as peso from cart_ax$prefix where idc={$rc->id}")->fetchObject();
		$q = --$rc->i;
		$tot = $rt->tot?$rt->tot:'';
		$vtot = $rt->tot+$rc->f;
	
		if($tot)$b->exec("update cart$prefix set v='$tot',t='$vtot',vd='$des',da=now(),i='{$rt->qp}',q='{$rt->qtd}',w='{$rt->peso}' where id={$rc->id}");
		else{
			$b->exec("delete from cart$prefix where id={$rc->id} limit 1");
		}
		$x->shopping->m = 'Produto removido com sucesso!';
		$x->shopping->ok = 1;
		$x->shopping->q = $q;
		$x->shopping->tot = nreal($rt->tot);
		$x->shopping->vtot = nreal($vtot);
		$x->shopping->peso = $rt->peso;
		$x->shopping->des = nreal($des);
		return $x->shopping;
	}
	public function update($id=0,$qt=0,$idc=0,$prefix=''){
		global $b;
		$ra = $b->query("select * from cart_ax$prefix where idp=$id and idc=$idc limit 1")->fetchObject();
		$t = $qt*$ra->v;
		$peso = $qt * $peso;
		$b->exec("update cart_ax$prefix set q=$qt,t='$t' where id='{$ra->id}'");
		$rt = $b->query("select sum(t) as stot from cart_ax$prefix where idc=$idc")->fetchObject();
		$vtot = $rt->stot;

		$b->exec("update cart$prefix set v='{$rt->stot}',t='$vtot',da=now() where id=$idc");
		$x->shopping->ok = 1;
		$x->shopping->m = 'Carrinho atualizado com sucesso!';
		$x->shopping->t = nreal($t);
		$x->shopping->tot = nreal($rt->stot);
		$x->shopping->vtot = nreal($vtot);
		return $x->shopping;
	}
	public function insertLogin($cookie,$id_cliente){
		global $b;
		$b->query("update cliente set cookie='$cookie' where id='$id_cliente' limit 1");//VOLTAR DEPOIS
		$sct = $b->query("select * from cart_temp where cookie='$cookie' limit 1");
		if($sct->rowCount()){
			$rct = $sct->fetchObject();
			$sat = $b->query("select * from cart_ax_temp where idc='{$rct->id}'");
			$sc = $b->query("select * from cart where idu='$id_cliente' and s=1 limit 1");
			if(!$sc->rowCount()){
				$b->exec("insert into cart set dc=now(),idu='$id_cliente',i='{$rct->i}',q={$rct->q},v='{$rct->v}'");
				$id = $b->lastInsertId();
				while($rat=$sat->fetchObject())$b->query("insert into cart_ax (idc,idp,idg,q,v,t) values('$id','{$rat->idp}','{$rat->idg}','{$rat->q}','{$rat->v}','{$rat->t}')");
				$rt = $b->query("select sum(v) as v,sum(t) as t,count(*) as i,sum(q) as q from cart_ax where idc='$id'")->fetchObject();
				$b->exec("update cart set v='{$rt->v}',t='{$rt->t}',i='{$rt->i}',q='{$rt->q}' where id='$id'");
				$b->exec("delete from cart_temp where id='{$rct->id}'");
				$b->exec("delete from cart_ax_temp where idc='{$rct->id}'");
			}else{
				$rc = $sc->fetchObject();
				$sat = $b->query("select * from cart_ax_temp where idc='{$rct->id}'");
				while($rat=$sat->fetchObject()){
					$sa = $b->query("select * from cart_ax where idc='{$rc->id}' and idp='{$rat->idp}'");
					if(!$sa->rowCount())$b->query("insert into cart_ax (idc,idp,q,v,t,p,w,pc) values('{$rc->id}','{$rat->idp}','{$rat->q}','{$rat->v}','{$rat->t}','{$rat->p}','{$rat->w}','{$rat->pc}')");
					else{
						$sa = $b->query("select * from cart_ax where idc='{$rc->id}' and idp='{$rat->idp}'");
						while($ra=$sa->fetchObject())if($rat->q!=$ra->q||$rat->v!=$ra->v||$rat->t!=$ra->t)$b->query("update cart_ax set q='{$rat->q}',v='{$rat->v}',t='{$rat->t}' where idc='{$rc->id}' and idp='{$rat->idp}'");
					}
				}
				$rt = $b->query("select sum(t) as t,count(*) as i,sum(q) as q from cart_ax where idc='{$rc->id}'")->fetchObject();
				$b->exec("update cart set t='{$rt->t}',i='{$rt->i}',q='{$rt->q}' where id='{$rc->id}'");
				$b->exec("delete from cart_temp where id='{$rct->id}'");
				$b->exec("delete from cart_ax_temp where idc='{$rct->id}'");
			}
		}
	}
}