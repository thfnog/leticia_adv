<?php
if($s->adm()){
	$id = strp('id',3);
	if($rs=$b->query("select id from sabor where id=$id limit 1")->fetchObject()){
		$sp = $b->query("select * from produto_estoque where id_sabor=$id");
		if($sp->rowCount())$x->m = 'Esse sabor não pode ser excluído, pois está vinculado com um produto!';
		else{
			if($b->exec("delete from sabor where id=$id limit 1")){
				$x->m = 'Sabor excluído com sucesso!';
				$x->ok = 1;
			}else $x->m = 'Erro ao excluir o sabor!';
		}
	}else $x->m = 'Este sabor não existe!';
}else $neg = true;