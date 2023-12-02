<?
if($s->adm()){
	$x->id = $id = strp('id',3);
	if($rs=$b->query("select id from pedido where id=$id limit 1")->fetchObject()){
		if($b->exec("update pedido set etiquetaGerada=0,plpGerada=0,plpFechada=0,plp=null,cod=null,etiquetaSemDv=null,codEnviado=null where id=$id limit 1")){
			$x->m = 'Etiqueta excluída com sucesso!';
			$x->l = "admin/pedido/$id";
			$x->ok = 1;
		}else $x->m = 'Erro ao excluir o E-mail!';
	}else $x->m = 'Este pedido não existe!';
}else $neg = true;
?>