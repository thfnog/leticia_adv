<?
if(!$s->idc){
	$id = strp('id',3);
	$email = strpr('email',1);
	$cod = strpr('cod',1);
	$p1 = strpr('p1');
	$p2 = strpr('p2');

	if(!$id&&$x->c='id')$x->m = 'Digite o ID!';
	elseif(!$email&&$x->c='email')$x->m = 'Digite o e-mail!';
	elseif(!preg_match($emailRE,$email)&&$x->c='email')$x->m = 'E-mail inválido!';
	elseif(!$cod&&$x->c='cod')$x->m = 'Digite o Código!';
	elseif(!preg_match($md5RE,$cod)&&$x->c='cod')$x->m = 'Código inválido!';
	elseif(!$p1&&$x->c='p1')$x->m = 'Digite a nova senha!';
	elseif(!$p2&&$x->c='p2')$x->m = 'Digite a confirmação da nova senha!';
	elseif($p1!=$p2&&$x->c='p2')$x->m = 'Confirmação da nova senha diferente!';
	else{
		$p1 = sha1($p1);
		$x->c = 'id';
		if($rs=$b->query("select email,cod from cliente where id=$id limit 1")->fetchObject()){
			$x->c = 'email';
			if($rs->email==$email){
				$x->c = 'cod';
				if($rs->cod==$cod){
					$x->c = '';
					if($b->exec("update cliente set p='$p1',cod=null where id=$id limit 1")){
						$x->m = 'Senha redefinida com sucesso!';
						$x->ok = 1;
					}else $x->m = 'Erro ao redefinir a senha!';
				}elseif($rs->cod)$x->m = 'Código Diferente!';
				else $x->m = 'Não foi enviado um link de redefinição de senha!';
			}else $x->m = 'E-mail diferente!';
		}else $x->m = 'Este ID não existe!';
	}
}else $neg = true;
?>