<?
if($s->adm()){
	$id = strp('id',3);
	if($rs=$b->query("select i,it from parceiro where id=$id limit 1")->fetchObject()){
		if($b->exec("delete from parceiro where id=$id limit 1")){
			$P = 'upload/parceiros/';
			$Pt = $P.'thumb/';
			if($rs->i)@unlink($P.$rs->i);
			if($rs->it)@unlink($Pt.$rs->it);
			$x->m = 'Parceiro excluído com sucesso!';
			$x->ok = 1;
		}else $x->m = 'Erro ao excluir o parceiro!';
	}else $x->m = 'Este parceiro não existe!';
}else $neg = true;
?>