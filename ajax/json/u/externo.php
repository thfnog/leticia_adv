<?php
if($s->adm()){
	$id = strp('id',3);
	$id = 1;
	$ga = strps('ga');
	$ad = strps('ad');
	$adConversion = strps('adConversion');
	$googleTagManager = strps('googleTagManager');
	$pixelFacebook = strps('pixelFacebook');
	$pixelFacebookObrigado = strps('pixelFacebookObrigado');
	$pixelFacebookContato = strps('pixelFacebookContato');

	$rs = $b->query("select id from codigo_externo where id=$id limit 1")->fetchObject();

	if($id&&!$rs&&++$N)$x->m = 'Esta página não existe!';
	else{
		if($b->exec("update codigo_externo set ga='$ga',ad='$ad',adConversion='$adConversion',pixelFacebook='$pixelFacebook',googleTagManager='$googleTagManager',pixelFacebookObrigado='$pixelFacebookObrigado',pixelFacebookContato='$pixelFacebookContato' where id=$id limit 1")){
			if($x->up)$b->exec("update codigo_externo set da=now() where id=$id limit 1");
			$x->ok = 1;
			$x->m = 'Códigos alterados com sucesso!';
		}else $x->m = 'Nenhum campo para alterar!';
	}
}else $neg = true;