<?php
if($s->adm()){
	$id = strp('id',3);
	$P = 'upload/blogs/';
	$Pt = $P.'thumb/';
	if($rs=$b->query("select id,t from blog where id=$id limit 1")->fetchObject()){
		$sf = $b->query("select * from fotos where idp=$id and tipo='blog'");
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
		if($sf->rowCount())$b->exec("delete from fotos where idp=$id and tipo='blog'");
		if($b->exec("delete from blog where id=$id limit 1")){
			$x->m = 'Post excluído com sucesso!';
			$x->ok = 1;
			$s->deleteSlug($rs->t);
			$s->siteMap('post-sitemap','post');
		}else $x->m = 'Erro ao excluir o post!';
	}else $x->m = 'Este post não existe!';
}else $neg = true;