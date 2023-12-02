<?php
if($s->adm()){
	$id = strp('id',3);
	$P = 'upload/produtos/';
	$Pt = $P.'thumb/';
	if($rs=$b->query("select id,t from produto where id=$id limit 1")->fetchObject()){
		$sf = $b->query("select * from fotos where idp=$id and tipo='produto'");
		while($rf=$sf->fetchObject()){
			if($rf->i)@unlink($P.$rf->i);
			if($rf->it)@unlink($Pt.$rf->it);
			if($rf->itc)@unlink($Pt.$rf->itc);
			if($rf->ith)@unlink($Pt.$rf->ith);
			if($rf->iti)@unlink($Pt.$rf->iti);
			if($rf->itm)@unlink($Pt.$rf->itm);
			if($rf->itr)@unlink($Pt.$rf->itr);
			if($rf->itu)@unlink($Pt.$rf->itu);
		}
		if($sf->rowCount())$b->exec("delete from fotos where idp=$id and tipo='produto'");
		if($b->exec("delete from produto where id=$id limit 1")){
			if($rs->i)@unlink($P.$rs->i);
			if($rs->it)@unlink($Pt.$rs->it);
			if($rs->iti)@unlink($Pt.$rs->iti);
			if($rs->itm)@unlink($Pt.$rs->itm);
			$x->m = 'Produto excluído com sucesso!';
			$x->ok = 1;
			$s->deleteSlug($rs->t);
			$s->siteMap('product-sitemap','produto');
		}else $x->m = 'Erro ao excluir o produto!';
	}else $x->m = 'Este produto não existe!';
}else $neg = true;