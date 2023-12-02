<?php
if($s->adm()){
	$id = strp('id',3);
	$P = 'upload/produtos/audios/';
	if($rs=$b->query("select id,f from produto_audio where id=$id limit 1")->fetchObject()){
		if($rs->f)@unlink($P.$rs->f);
		if($b->exec("delete from produto_audio where id=$id limit 1")){
			$x->m = 'Áudio excluído com sucesso!';
			$x->ok = 1;
		}else $x->m = 'Erro ao excluir o áudio!';
	}else $x->m = 'Este áudio não existe!';
}else $neg = true;