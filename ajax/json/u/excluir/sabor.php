<?
if($s->adm()){
	$id = strp('id',3);
	$S = strp('s',3)?1:0;
	$n = strps('n');
	$t = tag($n,1);

	$rs = $b->query("select id from sabor where id=$id")->fetchObject();

	if($id&&!$b->query("select id from sabor where id=$id limit 1")->fetchObject())$x->m = 'Este sabor não existe!';
	elseif(!$n)$x->m = 'Digite o sabor!';
	elseif($b->query("select id from sabor where id!=$id and t='$t' limit 1")->fetchObject())$x->m = 'Este sabor já está cadastrado!';
	else{
		$x->up = $id?1:0;
		if(!$id&&$b->exec("insert into sabor (dc)values(now())"))$id = $b->lastInsertId();
		if($b->exec("update sabor set s=$S,n='$n',t='$t' where id=$id limit 1")){
			if($x->up)$b->exec("update sabor set da=now() where id=$id limit 1");
			$x->ok = 1;
			$x->m = 'Sabor '.($x->up?'alterado':'cadastrado').' com sucesso!';
			if(!$x->up)$x->l = 'admin/sabor';
		}else $x->m = $x->up&&++$x->noup?'Nenhum campo para alterar!':'Erro ao cadastar o sabor!';
	}
}else $neg = true;
?>