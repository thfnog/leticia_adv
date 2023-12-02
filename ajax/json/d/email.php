<?
if($s->adm()){
	$id = strp('id',3);
	if($rs=$b->query("select id from email where id=$id limit 1")->fetchObject()){
		if($b->exec("delete from email where id=$id limit 1")){
			$x->m = 'E-mail excluido com sucesso!';
			$x->ok = 1;
		}else $x->m = 'Erro ao excluir o E-mail!';
	}else $x->m = 'Este E-mail não existe!';
}else $neg = true;
?>