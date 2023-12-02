<?php
if($s->adm()){
	$id = strp('id',3);
	$idp = strp('idp',3);
	$idp = $idp?$idp:'null';
	$S = strp('s',3)?1:0;
	$idu = $s->idu;
	$principal = strp('principal',3);
	$page = 'servico';
	$siteMap = 'servico-sitemap';
	$x->h1 = $h1 = strps('h1');
	$x->n = $n = strps('n');
	$t = tag($n,1);
	if($t)$checkSlug = $s->checkSlug($id,$t);

	$d = strps('d');
	$r = strps('r');

	$tags = strps('tags');

	$tagd = strps('tagd');
	$tagt = strps('tagt')?strps('tagt'):$h1;

	$rs = $b->query("select id from servico where id=$id limit 1")->fetchObject();

	if($_dp=preg_match($dataRE,$dp,$_m))$dp = "{$_m[3]}-{$_m[2]}-{$_m[1]}";
	$m = tag(datef($dp,61),1);

	if($id&&!$rs&&++$N)$x->m = 'Este post não existe!';
	elseif(!$h1)$x->m = 'Digite o título (h1)!';
	elseif(!$n)$x->m = 'Digite o slug do servico usado para url!';
	elseif($checkSlug=='indisponivel')$x->m = 'Esta slug já está sendo utilizada, por favor altere a slug!';
	elseif(!$d)$x->m = 'Digite a descrição!';
	elseif(!$r)$x->m = 'Digite o resumo da descrição!';
	else{
		$x->up = $id?1:0;
		if(!$id&&$b->exec("insert into servico set dc=now()"))$id = $b->lastInsertId();
		if($b->exec($x->upd="update servico set s=$S,idu=$idu,n='$n',h1='$h1',t='$t',d='$d',r='$r',tagd='$tagd',tagt='$tagt' where id=$id limit 1")){
			$x->ok = 1;
			$x->m = 'Serviço '.($x->up?'alterado':'cadastrado').' com sucesso!';
			if($x->up)$s->updateSlug($id,$t,$page);
			else $s->insertSlug($id,$t,$page);
		}elseif($x->up)$x->noup = 1;
		else $x->m = 'Erro ao cadastar o serviço!';
		if($id){
			if($principal){
				$sfoto = $b->query("select id from fotos where id=$principal and idp=$id and tipo='servico' and principal limit 1");
				if(!$sfoto->rowCount()){				
					$b->exec("update fotos set principal=1,da=now() where id=$principal and idp=$id and tipo='servico' limit 1");
					$b->exec("update fotos set principal=0,da=now() where id!=$principal and idp=$id and tipo='servico'");
					$x->ok = 1;
				}
			}
			//TAGS
			if($tags){
				$tag = explode(", ",$tags);
				foreach($tag as $k=>&$v){
					$n = &$v;
					$t = tag($n,1);
					$rs = $b->query("select idp from tag where n='$n' and idp=$id and tipo='servico' limit 1")->fetchObject();
					if(!$rs&&$t&&$b->exec("insert into tag (idp,n,t,dc,tipo)values($id,'$n','$t',now(),'servico')"))$x->ok = 1;
					$re = $b->query("select id from tag where t='$t' and idp=$id and tipo='servico' limit 1")->fetchObject();
					$ntag[] = $re->id;
				}
				if($ntag){
					$ntag2 = implode(",",$ntag);
					$del = $b->query("delete from tag where idp=$id and tipo='servico' and id not in($ntag2)");
					if($del->rowCount())$x->ok = 1;
				}
			}else{
				$del = $b->query("delete from tag where idp=$id and tipo='servico'");
				if($del->rowCount())$x->ok = 1;
			}
		}
		if($x->ok){
			$s->siteMap($siteMap,$page);
			if($x->up)$b->exec("update servico set da=now() where id=$id limit 1");
			if(!$x->m)$x->m = 'Serviço'.($x->up?'alterado':'cadastrado').' com sucesso!';
			$x->ok = 1;
			if(!$x->up)$x->l = 'admin/servico-foto/'.$id;
		}elseif($x->noup)$x->m = 'Nenhum campo para alterar!';
	}
}else $neg = true;