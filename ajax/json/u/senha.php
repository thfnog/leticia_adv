<?
if($s->adm()){
	$p = strpr('pass');
	$p1 = strpr('p1');
	$p2 = strpr('p2');
	if(!$p)$x->m = 'Digite a senha antiga!';
	elseif(!$p1)$x->m = 'Digite a nova senha!';
	elseif(!$p2)$x->m = 'Digite a confirmação da nova senha!';
	elseif($p1!=$p2)$x->m = 'Confirmação da nova senha diferente!';
	elseif($p==$p1)$x->m = 'Senha antiga e nova senha são iguais!';
	else{
		$p = sha1(strpr('pass'));
		$p1 = sha1(strpr('p1'));
		$p2 = sha1(strpr('p2'));
		if(($rs=$b->query("select p from user where id={$s->idu} limit 1")->fetchObject())&&$p==$rs->p){
			if($b->exec("update user set p='$p1' where id={$s->idu} limit 1")){
				$x->m = 'Senha alterada com sucesso!';
				$x->ok = 1;
			}else $x->m = 'Ocorreu um erro, tente novamente!';
		}else $x->m = 'Senha antiga incorreta!';
	}
}else $neg = true;
?>