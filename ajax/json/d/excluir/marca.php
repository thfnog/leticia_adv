<?php
if($s->adm()){
	$id = strp('id',3);
	if($id==1)$x->m = 'Essa marca não pode ser excluída!';
	else{
		if($rs=$b->query("select id from marca where id=$id limit 1")->fetchObject()){
			if($b->exec("delete from marca where id=$id limit 1")){
				$x->m = 'Marca excluída com sucesso!';
				$x->ok = 1;
			}else $x->m = 'Erro ao excluir a marca!';
		}else $x->m = 'Esta marca não existe!';
	}
}else $neg = true;