<?
if($s->adm()){
	$id = strp('id',3);
	if($rs=$b->query("select i from slider where id=$id limit 1")->fetchObject()){
		if($b->exec("delete from slider where id=$id limit 1")){
			if($rs->i)@unlink('upload/sliders/'.$rs->i);
			$x->m = 'Slider excluído com sucesso!';
			$x->ok = 1;
		}else $x->m = 'Erro ao excluir o slider!';
	}else $x->m = 'Este slider não existe!';
}else $neg = true;
?>