<?
if($s->adm(1)){
	$id = strp('id',3);
	if($id==$s->idu)$x->m = 'Você não pode se auto-excluir!';
	elseif($rs=$b->query("select id from user where id=$id and t=5 limit 1")->fetchObject()){
		if($b->exec("delete from user where id=$id and t=5 limit 1")){
			$x->m = 'Atleta excluído com sucesso!';
			$x->ok = 1;
		}else $x->m = 'Erro ao excluir o atleta!';
	}else $x->m = 'Este atleta não existe!';
}else $neg = true;
?>