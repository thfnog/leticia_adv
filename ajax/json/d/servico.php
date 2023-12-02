<?php
if($s->adm()){
	$id = strp('id',3);
	$P = 'upload/servicos/';
	$Pt = $P.'thumb/';
	if($rs=$b->query("select id,t from servico where id=$id limit 1")->fetchObject()){
		$sf = $b->query("select * from fotos where idp=$id and tipo='servico'");
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
		if($sf->rowCount())$b->exec("delete from fotos where idp=$id and tipo='servico'");
		if($b->exec("delete from servico where id=$id limit 1")){
			$x->m = 'Serviço excluído com sucesso!';
			$x->ok = 1;
			$s->deleteSlug($rs->t);
			$s->siteMap('servico-sitemap','servico');
		}else $x->m = 'Erro ao excluir o serviço!';
	}else $x->m = 'Este serviço não existe!';
}else $neg = true;