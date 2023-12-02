<?php
if($s->adm()){
	$id = strp('id',3);
	$id = 1;
	$S = strp('s',3)?1:0;
	$h1 = strps('h1');
	$d = strps('d');
	$tagd = strps('tagd');
	$tagk = strps('tagk');
	$tagt = strps('tagt')?strps('tagt'):$n;
	$principal = strp('principal',3);

	$rs = $b->query("select id from empresa where id=$id limit 1")->fetchObject();

	if($id&&!$rs&&++$N)$x->m = 'Esta página não existe!';
	elseif(!$h1)$x->m = 'Digite título!';
	elseif(!$d)$x->m = 'Digite a descrição!';
	else{
		if($b->exec("update empresa set s=$S,h1='$h1',d='$d',tagd='$tagd',tagk='$tagk',tagt='$tagt' where id=$id limit 1")){
			if($x->up)$b->exec("update empresa set da=now() where id=$id limit 1");
			$x->ok = 1;
			$x->m = 'Página alterada com sucesso!';
		}elseif($x->up)$x->noup = 1;
		if($id){
			if($principal){
				$sfoto = $b->query("select id from fotos where id=$principal and idp=$id and tipo='quem-somos' and principal limit 1");
				if(!$sfoto->rowCount()){				
					$b->exec("update fotos set principal=1,da=now() where id=$principal and idp=$id and tipo='quem-somos' limit 1");
					$b->exec("update fotos set principal=0,da=now() where id!=$principal and idp=$id and tipo='quem-somos'");
					$x->ok = 1;
				}
			}
		}
		if($x->ok){
			if($x->up)$b->exec("update empresa set da=now() where id=$id limit 1");
			if(!$x->m)$x->m = 'Quem Somos alterado com sucesso!';
			$x->ok = 1;
		}elseif($x->noup)$x->m = 'Nenhum campo para alterar!';
	}
}else $neg = true;