<?
if($s->adm()){
	$M = $id = strp('id',3);
	$n = strps('n');
	$t = tag($n,1);
	$d = strps('d');

	if($id&&!$b->query("select id from grupo where id=$id limit 1")->fetchObject())$x->m = 'Este Grupo não existe!';
	elseif(!$n)$x->m = 'Digite o nome do Grupo!';
	elseif($b->query("select id from grupo where id!=$id and t='$t' limit 1")->fetchObject())$x->m = 'Este Grupo já está cadastrado!';
	else{
		if(!$id&&$b->exec("insert into grupo (dc)values(now())"))$id = $b->lastInsertId();
		if($b->exec("update grupo set n='$n',t='$t',d='$d' where id=$id limit 1")){
			if($M)$b->exec("update grupo set da=now() where id=$id limit 1");
			$x->ok = 1;
			$x->m = 'Grupo '.($M?'alterado':'cadastrado').' com sucesso!';
		}else $x->m = $M?'Nenhum campo para alterar!':'Erro ao cadastar o Grupo!';
	}
}else $neg = true;
?>