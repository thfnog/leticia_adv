<?
if($s->adm()){
	$id = strp('id',3);
	$S = strp('s',3)?1:0;
	$n = strps('n');
	$t = tag($n,1);
	$peso = strps('peso');
	$largura = strps('largura');
	$altura = strps('altura');
	$comprimento = strps('comprimento');

	$rs = $b->query("select id from peso where id=$id")->fetchObject();

	if($id&&!$rs&&++$N)$x->m = 'Este peso não existe!';
	elseif(!$n)$x->m = 'Digite o título do peso!';
	elseif($b->query("select id from peso where id!=$id and t='$t' limit 1")->fetchObject())$x->m = 'Este peso já está cadastrado!';
	elseif(!isset($largura))$x->m = 'Digite a largura!';
	elseif(isset($largura)&&$largura<11)$x->m = 'A largura mínima é 11cm!';
	elseif(!isset($altura))$x->m = 'Digite a altura!';
	elseif(isset($altura)&&$altura<2)$x->m = 'A altura mínima é 2cm!';
	elseif(!isset($comprimento))$x->m = 'Digite o comprimento!';
	elseif(isset($comprimento)&&$comprimento<16)$x->m = 'O comprimento mínimo é 16cm!';
	elseif(!isset($peso))$x->m = 'Digite o peso!';
	else{
		$x->up = $id?1:0;
		if(!$id&&$b->exec("insert into peso set dc=now()"))$id = $b->lastInsertId();
		if($b->exec($x->upd="update peso set s=$S,n='$n',t='$t',peso='$peso',largura='$largura',altura='$altura',comprimento='$comprimento' where id=$id limit 1")){
			if($x->up)$b->exec("update peso set da=now() where id=$id limit 1");
			$x->ok = 1;
			$x->m = 'Peso '.($x->up?'alterado':'cadastrado').' com sucesso!';
		}else $x->m = $x->up&&++$x->noup?'Nenhum campo para alterar!':'Erro ao cadastar o peso!';
	}
}else{
	if(!$s->adm())$neg = true;
	else $x->m = 'Você não pode adicionar pesos no site!';
}
?>