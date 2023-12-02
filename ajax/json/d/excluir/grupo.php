<?
if($s->adm()){
	$id = strp('id',3);
	if(!$id)$x->m = 'Escolha um Grupo para excluir!';
	elseif($id===1)$x->m = 'Este Grupo não pode ser excluido!';
	elseif($rs=$b->query("select id from grupo where id=$id limit 1")->fetchObject()){
		if($b->exec("delete from grupo where id=$id limit 1")){
			$x->m = 'Grupo excluido com sucesso!';
			$x->ok = 1;
		}else $x->m = 'Erro ao excluir o Grupo!';
	}else $x->m = 'Este Grupo não existe!';
}else $neg = true;
?>