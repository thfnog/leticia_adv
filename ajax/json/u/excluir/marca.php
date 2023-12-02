<?
if($s->adm()){
	$id = strp('id',3);
	$S = strp('s',3)?1:0;
	$h1 = strps('h1');
	$n = strps('n');
	$t = tag($n,1);
//SEO
	$tagd = strps('tagd');
	$tagk = strps('tagk');
	$tagt = strps('tagt')?strps('tagt'):$n;
//SEO

	$rs = $b->query("select id from marca where id=$id")->fetchObject();

	if($id&&!$b->query("select id from marca where id=$id limit 1")->fetchObject())$x->m = 'Esta marca não existe!';
	elseif(!$h1)$x->m = 'Digite o h1 da marca!';
	elseif(!$n)$x->m = 'Digite o nome da marca!';
	elseif($b->query("select id from marca where id!=$id and t='$t' limit 1")->fetchObject())$x->m = 'Esta marca já está cadastrada!';
	else{
		$x->up = $id?1:0;
		if(!$id&&$b->exec("insert into marca (dc)values(now())"))$id = $b->lastInsertId();
		if($b->exec("update marca set s=$S,h1='$h1',n='$n',t='$t',tagd='$tagd',tagk='$tagk',tagt='$tagt' where id=$id limit 1")){
			if($x->up)$b->exec("update marca set da=now() where id=$id limit 1");
			$x->ok = 1;
			$x->m = 'Marca '.($x->up?'alterada':'cadastrada').' com sucesso!';
			if(!$x->up)$x->l = 'admin/marca';
		}else $x->m = $x->up&&++$x->noup?'Nenhum campo para alterar!':'Erro ao cadastar a marca!';
	}
}else $neg = true;
?>