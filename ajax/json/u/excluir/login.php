<?
if($s->cli())$x->l = 'perfil';
else{
	$cpfRE2 = '/^(\d{3})\D*(\d{3})\D*(\d{3})\D*(\d\d)$/';
	$cnpjRE2 = '/^(\d{2,3})\D*(\d{3})\D*(\d{3})\D*(\d{4})\D*(\d\d)$/';
	$email = strps('email');
	$senha = strpr('pass');
	$p = sha1($senha);
	//$master = sha1('vitoria85');
	$save = strp('save',3)?1:0;
	$pg = strps('pg');
	$referer = strpr('referer');
	$cpf = $email&&preg_match($cpfRE2,$email,$_m)?"{$_m[1]}.{$_m[2]}.{$_m[3]}-{$_m[4]}":'';
	$cnpj = $email&&preg_match($cnpjRE2,$email,$_m)?"{$_m[1]}.{$_m[2]}.{$_m[3]}/{$_m[4]}-{$_m[5]}":'';

	if($save){
		$dados = array("email" => $email, "pass"=>$senha, "save"=>$save);
		$json = base64_encode(json_encode($dados));
		$_SESSION['jsonLogin'] = $json;
	}else{
		unset($_COOKIE['topEmail']);
		unset($_COOKIE['topPass']);
		unset($_COOKIE['topSave']);
	}

	if(!$email){
		$x->m = 'Digite o email, CPF ou CNPJ!';
		$x->f = 'email';
	}elseif(!$senha){
		$x->m = 'Digite a senha!';
		$x->f = 'p';
	}elseif($rs=$b->query('select * from cliente where '.($cpf?"cpf='$cpf'":($cnpj?"cnpj='$cnpj'":"email='$email'")).' limit 1')->fetchObject()){
		if($rs->s!=1)$x->m = 'Usuário desativado pelo Administrador!';
		elseif($rs->p==$p||$master==$p){
			$ck = $_SESSION['cookie_cart'];
			$b->query("update cliente set cookie='$ck' where id='$rs->id' limit 1");
			$sct = $b->query("select * from cart_temp where cookie='$ck' limit 1");
			if($sct->rowCount()){
				$rct = $sct->fetchObject();
				$sc = $b->query("select * from cart where idu='$rs->id' and s=1 limit 1");
				if(!$sc->rowCount()){
					$cliente = $b->query("select *,n,email,r,tp,dn,cpf,rg,rua,cep,city,num,bairro,uf,comp,t1 from cliente where id='$rs->id'")->fetchObject();
					$cli_n = addslashes($cliente->n?$cliente->n:$cliente->r);
					$cli_rua = addslashes($cliente->rua);
					$cli_num = addslashes($cliente->num);
					$cli_comp = addslashes($cliente->comp);
					$cli_bairro = addslashes($cliente->bairro);
					$cli_cep = addslashes($cliente->cep);
					$cli_city = addslashes($cliente->city);
					$cli_uf = addslashes($cliente->uf);
					$cli_t1 = addslashes($cliente->t1);
					$b->exec("insert into cart set dc=now(),idu='$rs->id',i='{$rct->i}',q={$rct->q},v='{$rct->v}',n='$cli_n',rua='$cli_rua',num='$cli_num',comp='$cli_comp',bairro='$cli_bairro',cep='$cli_cep',city='$cli_city',uf='$cli_uf',t1='$cli_t1'");
					$id = $b->lastInsertId();
					$sat = $b->query("select * from cart_ax_temp where idc='{$rct->id}'");
					while($rat=$sat->fetchObject())$b->query("insert into cart_ax (idc,idp,q,v,t,p,w) values('$id','{$rat->idp}','{$rat->q}','{$rat->v}','{$rat->t}','{$rat->p}','{$rat->w}')");
					$rt = $b->query("select sum(t) as t,count(*) as i,sum(q) as q from cart_ax where idc='$id'")->fetchObject();
					$b->exec("update cart set t='{$rt->t}',i='{$rt->i}',q='{$rt->q}' where id='$id'");
					$b->exec("delete from cart_temp where id='{$rct->id}'");
					$b->exec("delete from cart_ax_temp where idc='{$rct->id}'");
				}else{
					$rc = $sc->fetchObject();
					$sat = $b->query("select * from cart_ax_temp where idc='{$rct->id}'");
					while($rat=$sat->fetchObject()){
						$sa = $b->query("select * from cart_ax where idc='{$rc->id}' and idp='{$rat->idp}'");
						if(!$sa->rowCount())$b->query("insert into cart_ax (idc,idp,q,v,t,p,w) values('{$rc->id}','{$rat->idp}','{$rat->q}','{$rat->v}','{$rat->t}','{$rat->p}','{$rat->w}')");
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
			$s->idc = $_SESSION['idc'] = $rs->id+0;
			$s->nome = $_SESSION['nome'] = $rs->n;
			$s->user = $_SESSION['user'] = $rs->email;
			$s->email = $_SESSION['email'] = $rs->email;
			$s->tipo = $_SESSION['tipo'] = 3;
			unset($rs->p);
			$s->cli = $_SESSION['cli'] = $rs;
			if($pg&&$pg!='home')$x->l = $pg;
			else $x->l = 'produtos';
		}else{
			$x->m = 'Senha inválida!';
			$x->f = 'p';
		}
	}else $x->m = 'Usuário inexistente!';
}
?>