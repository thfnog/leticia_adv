<?php
if($s->adm()){
	$id = strp('id',3);
	$idp = strp('idp',3);
	$S = strp('s',3)?1:0;
	$idu = $s->idu;
	$principal = strp('principal',3);
	$h1 = strps('h1');
	$n = strps('n');
	$t = tag($n,1);
	$dp = strps('dp');
	$page = 'objetivo';

	$d = strps('d');
	$r = strps('r');

	$tagd = strps('tagd');
	$tagt = strps('tagt')?strps('tagt'):$n;

	$rs = $b->query("select id from objetivo where id=$id limit 1")->fetchObject();

	if($_dp=preg_match($dataRE,$dp,$_m))$dp = "{$_m[3]}-{$_m[2]}-{$_m[1]}";
	$m = tag(datef($dp,61),1);

	if($id&&!$rs&&++$N)$x->m = 'Este post não existe!';
	elseif(!$h1)$x->m = 'Digite o título (h1)!';
	elseif(!$n)$x->m = 'Digite o slug do objetivo usado para url!';
	elseif($checkSlug=='indisponivel')$x->m = 'Esta slug já está sendo utilizada, por favor altere a slug!';
	elseif(!$dp)$x->m = 'Digite a data do post!';
	elseif(!$d)$x->m = 'Digite a descrição!';
	elseif(!$r)$x->m = 'Digite o resumo da descrição!';
	else{
		$x->up = $id?1:0;
		if(!$id&&$b->exec("insert into objetivo set dc=now()"))$id = $b->lastInsertId();
		if($b->exec($x->upd="update objetivo set s=$S,idu=$idu,n='$n',h1='$h1',t='$t',dp='$dp',m='$m',d='$d',r='$r',tagd='$tagd',tagt='$tagt' where id=$id limit 1")){
			$x->ok = 1;
			$x->m = 'Objetivo '.($x->up?'alterado':'cadastrado').' com sucesso!';
			if($x->up)$s->updateSlug($id,$t,$page);
			else $s->insertSlug($id,$t,$page);
		}elseif($x->up)$x->noup = 1;
		else $x->m = 'Erro ao cadastar o objetivo!';
		if($id){
			//PRODUTOS RELACIONADOS
			if($idp)foreach($idp as $k=>&$v){
				$idp = &$v;
				$rs = $b->query("select ido from objetivo_produto where idp='$idp' and ido=$id limit 1")->fetchObject();
				if(!$rs&&$idp&&$b->exec("insert into objetivo_produto (idp,ido,dc)values($idp,$id,now())"))$x->ok = 1;
				$re = $b->query("select idp from objetivo_produto where idp='$idp' and ido=$id")->fetchObject();
				$nidp[] = $re->idp;
			}
			if($nidp){
				$nidp2 = implode(",",$nidp);
				$del = $b->query("delete from objetivo_produto where ido=$id and idp not in($nidp2)");
				if($del->rowCount())$x->ok = 1;
			}else{
				$del = $b->query("delete from objetivo_produto where ido=$id and idp!=$idp");
				if($del->rowCount())$x->ok = 1;
			}
			if($principal){
				$sfoto = $b->query("select id from fotos where id=$principal and idp=$id and tipo='objetivo' and principal limit 1");
				if(!$sfoto->rowCount()){				
					$b->exec("update fotos set principal=1,da=now() where id=$principal and idp=$id and tipo='objetivo' limit 1");
					$b->exec("update fotos set principal=0,da=now() where id!=$principal and idp=$id and tipo='objetivo'");
					$x->ok = 1;
				}
			}
		}
		if($x->ok){
			$s->siteMap('post-sitemap','objetivo');
			if($x->up)$b->exec("update objetivo set da=now() where id=$id limit 1");
			if(!$x->m)$x->m = 'Objetivo '.($x->up?'alterado':'cadastrado').' com sucesso!';
			$x->ok = 1;
			if(!$x->up)$x->l = 'admin/objetivo-foto/'.$id;
		}elseif($x->noup)$x->m = 'Nenhum campo para alterar!';
	}
}else $neg = true;