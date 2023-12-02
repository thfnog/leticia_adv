<?php
if($s->adm()){
	$id = strp('id',3);
	$S = strp('s',3)?1:0;
	$n = strps('n');
	$t = tag($n,1);
	$d = strps('d');
	$tagd = strps('tagd');
	$tagk = strps('tagk');
	$tagt = strps('tagt')?strps('tagt'):$n;

	$rs = $b->query("select id from termos where id=$id limit 1")->fetchObject();

	if($id&&!$rs&&++$N)$x->m = 'Esta página não existe!';
	elseif(!$n)$x->m = 'Digite título!';
	elseif(!$d)$x->m = 'Digite a descrição!';
	else{
		if($b->exec("update termos set s=$S,n='$n',d='$d',tagd='$tagd',tagk='$tagk',tagt='$tagt' where id=$id limit 1")){
			if($x->up)$b->exec("update termos set da=now() where id=$id limit 1");
			$x->ok = 1;
			$x->m = 'Página alterada com sucesso!';
		}else $x->m = 'Nenhum campo para alterar!';
	}
}else $neg = true;