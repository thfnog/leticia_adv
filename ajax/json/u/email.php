<?
if($s->adm()){
	$M = $id = strp('id',3);
	$idg = strp('idg',3);
	$a = strp('s',3)?1:0;
	$e = strps('email',1);

	if($id&&!$b->query("select id from email where id=$id limit 1")->fetchObject())$x->m = 'Este E-mail não existe!';
	elseif(!$idg)$x->m = 'Selecione o Grupo!';
	elseif(!$b->query("select id from grupo where id=$idg limit 1")->fetchObject())$x->m = 'Este Grupo não existe!';
	elseif(!$e)$x->m = 'Digite o E-mail!';
	elseif(!preg_match($emailRE,$e))$x->m = 'E-mail inválido!';
	elseif($b->query("select id from email where idg=$idg and id!=$id and email='$e' limit 1")->fetchObject())$x->m = 'Este E-mail já está cadastrado neste Grupo!';
	else{
		if(!$id&&$b->exec("insert into email (dc)values(now())"))$id = $b->lastInsertId();
		if($b->exec("update email set idg=$idg,s=$a,email='$e' where id=$id limit 1")){
			if($M)$b->exec("update email set da=now() where id=$id limit 1");
			$x->ok = 1;
			$x->m = 'E-mail '.($M?'alterado':'cadastrado').' com sucesso!';
		}else $x->m = $M?'Nenhum campo para alterar!':'Erro ao cadastar o E-mail!';
	}
}else $neg = true;
?>