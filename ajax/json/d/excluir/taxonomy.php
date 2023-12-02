<?php
if($s->adm()){
	$id = strp('id',3);
	if($rs=$b->query("select i,it,ih,ith,id,idp from cat where id=$id limit 1")->fetchObject()){
		if($b->exec("delete from cat where id=$id limit 1")){
			if($rs->idp==0)$b->query("update cat set idp=0 where idp='{$rs->id}'");
			else $b->query("update cat set idp='{$rs->idp}' where idp='{$rs->id}'");
			$P = 'upload/categorias/';
			$Pt = $P.'thumb/';
			if($rs->i)@unlink($P.$rs->i);
			if($rs->it)@unlink($Pt.$rs->it);
			if($rs->ih)@unlink($P.$rs->ih);
			if($rs->ith)@unlink($Pt.$rs->ith);
			$x->m = 'Categoria excluída com sucesso!';
			$x->ok = 1;
		}else $x->m = 'Erro ao excluir a categoria!';
	}else $x->m = 'Esta cateoria não existe!';
}else $neg = true;