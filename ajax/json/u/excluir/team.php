<?php
if($s->adm()){
	$id = strp('id',3);
	$S = strp('s',3)?1:0;
	$principal = strp('principal',3);
	$nome = strps('nome');
	$funcao = strps('funcao');
	$facebook = strps('facebook');
	$instagram = strps('instagram');
	$twitter = strps('twitter');
	$linkedin = strps('linkedin');
	$youtube = strps('youtube');
	$pinterest = strps('pinterest');
	$plus = strps('plus');

	$rs = $b->query("select id from team where id=$id limit 1")->fetchObject();

	if($id&&!$rs&&++$N)$x->m = 'Este membro não existe!';
	elseif(!$nome)$x->m = 'Digite o nome!';
	elseif(!$funcao)$x->m = 'Digite a função!';
	else{
		$x->up = $id?1:0;
		if(!$id&&$b->exec("insert into team set dc=now()"))$id = $b->lastInsertId();
		if($b->exec($x->upd="update team set s=$S,nome='$nome',funcao='$funcao',facebook='$facebook',instagram='$instagram',twitter='$twitter',linkedin='$linkedin',youtube='$youtube',pinterest='$pinterest',plus='$plus' where id=$id limit 1")){
			$x->ok = 1;
			$x->m = 'Post '.($x->up?'alterado':'cadastrado').' com sucesso!';
		}elseif($x->up)$x->noup = 1;
		else $x->m = 'Erro ao cadastar o team!';
		if($id){
			if($principal){
				$sfoto = $b->query("select id from fotos where id=$principal and idp=$id and tipo='team' and principal limit 1");
				if(!$sfoto->rowCount()){				
					$b->exec("update fotos set principal=1,da=now() where id=$principal and idp=$id and tipo='team' limit 1");
					$b->exec("update fotos set principal=0,da=now() where id!=$principal and idp=$id and tipo='team'");
					$x->ok = 1;
				}
			}
		}
		if($x->ok){
			if($x->up)$b->exec("update team set da=now() where id=$id limit 1");
			if(!$x->m)$x->m = 'Membro '.($x->up?'alterado':'cadastrado').' com sucesso!';
			$x->ok = 1;
			if(!$x->up)$x->l = 'admin/team-foto/'.$id;
		}elseif($x->noup)$x->m = 'Nenhum campo para alterar!';
	}
}else $neg = true;