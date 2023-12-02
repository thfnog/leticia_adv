<?php
if($s->adm()){
	//$id = strp('id',3);
	$id = 0;
	$idp = strp('id',3);
	$S = strp('s',3)?1:0;
	$n = strps('n');
	$t = tag($n,1);

	$P = 'upload/produtos/audios/';

	$Rf = strp('rf',3)?1:0;
	$f = $s->getfile(strp('f',3));
	$F = 'f';
	$Df = '';

	$rs = $b->query("select id from produto where id=$idp limit 1")->fetchObject();

	if($idp&&!$rs&&++$N)$x->m = 'Este produto não existe!';
	elseif(!$n)$x->m = 'Digite o título do áudio!';
	elseif(!$f)$x->m = 'Selecione o áudio!';
	elseif($f&&$f->e&&++$N)$x->m = 'Ocorreu um erro ao fazer upload do arquivo!';
	elseif($f->ex!='mp3'&&++$N)$x->m = 'O arquivo deve ser MP3!';
	else{
		$x->up = $id?1:0;
		if(!$id&&$b->exec("insert into produto_audio set dc=now(),idp=$idp"))$id = $b->lastInsertId();
		if($Rf){
			$x->i->f = '';
			$F = 'null';
			$Df = $rs->f;
		}elseif($f){
			$C = tag($n,1).'-'.date('his').'.'.$f->ex;
			if($f=$s->movefile($f->id,$P.$C)){
				$x->i->f = $P.$C;
				$F = "'$C'";
				$Df = $rs->f;
			}
		}
		if($b->exec($sql="update produto_audio set s=$S,n='$n',t='$t',f=$F where id=$id limit 1")){
			if($x->up)$b->exec("update produto_audio set da=now() where id=$id limit 1");
			if($Df)@unlink($P.$Df);
			$x->ok = 1;
			$x->m = 'Áudio '.($x->up?'alterado':'cadastrado').' com sucesso!';
			$x->l = 'admin/audio/'.$idp;
		}else $x->m = $x->up&&++$x->noup?'Nenhum campo para alterar!':'Erro ao cadastar o áudio!';
	}
	if($f&&$N&&++$x->noi->f){
		$s->delfile($f->id);
	}
}else $neg = true;	