<?php
if($s->adm()){
	$id = strp('id',3);
	if($rs=$b->query("select id from cat where id=$id limit 1")->fetchObject()){
		if($b->exec("delete from cat where id=$id limit 1")){
			$x->m = 'Categoria excluída com sucesso!';
			$x->ok = 1;
			$s->siteMap('category-sitemap','categoria');
		}else $x->m = 'Erro ao excluir a categoria!';
	}else $x->m = 'Esta categoria não existe!';
}else $neg = true;