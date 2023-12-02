<?
if($s->adm()){
	$id = strp('id',3);
	$msg = strps('msg');

	$rs = $b->query("select id from formulario where id=$id")->fetchObject();

	if($id&&!$rs)$x->m = 'Este formulário não existe!';
	elseif(!$msg)$x->m = 'Digite a mensagem!';
	else{
		$b->exec("insert into formulario_ax set dc=now(),id_user='{$s->idu}',id_formulario=$id,mensagem='$msg'");
		$x->l = 'admin/contato/'.$id;
	}
}else $neg = true;
?>