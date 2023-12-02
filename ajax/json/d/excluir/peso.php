<?php
if($s->adm()){
	$id = strp('id',3);
	if($rs=$b->query("select id from peso where id=$id limit 1")->fetchObject()){
		$sp = $b->query("select * from produto_estoque where id_peso=$id");
		if($sp->rowCount())$x->m = 'Esse peso não pode ser excluído, pois está vinculado com um produto!';
		else{
			if($b->exec("delete from peso where id=$id limit 1")){
				$x->m = 'Peso excluído com sucesso!';
				$x->ok = 1;
			}else $x->m = 'Erro ao excluir o peso!';
		}
	}else $x->m = 'Este peso não existe!';
}else $neg = true;