<?php
if($s->adm()){
	$x->id = $id = strp('id',3);
	if($rs=$b->query("select id from blog where id=$id limit 1")->fetchObject()){
		if($b->exec("insert into blog (idc,dc,dp,m,h1,n,t,r,d,tagt,tagd) select idc,now(),dp,m,h1,n,t,r,d,tagt,tagd from blog where id=$id")){
			$id_novo = $b->lastInsertId();
			$b->query("update blog set s=0 where id=$id_novo limit 1");
			$x->m = 'Post copiado com sucesso!';
			$x->ok = 1;

			$P = 'upload/blogs/';
			$Pt = $P.'thumb/';
			$tipo = 'blog';
			$fotos = $b->query("select * from fotos where idp=$id and tipo='$tipo'");
			if($fotos->rowCount())$s->cloneFotos($id,$id_novo,$P,$Pt,$tipo);
		}else $x->m = 'Erro ao copiar o post!';
	}else $x->m = 'Este post não existe!';
}else $neg = true;