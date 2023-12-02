<?
if($s->adm()){
	$id = strp('id',3);
	$title = strps('title');
	$alt = strps('alt');

	$rs = $b->query("select id from fotos where id=$id")->fetchObject();

	if(!$rs)$x->m = 'Esta foto não existe!';
	elseif(!$title)$x->m = 'Digite o title!';
	elseif(!$alt)$x->m = 'Digite o alt!';
	else{
		$x->up = $id?1:0;
		if($b->exec("update fotos set title='$title',alt='$alt' where id=$id limit 1")){
			if($x->up)$b->exec("update fotos set da=now() where id=$id limit 1");
			$x->ok = 1;
			$x->m = 'Foto '.($x->up?'alterada':'cadastrada').' com sucesso!';
		}else $x->m = $x->up&&++$x->noup?'Nenhum campo para alterar!':'Erro ao cadastar a foto!';
	}
}else $neg = true;
?>