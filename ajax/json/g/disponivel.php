<?php
$email = strg('email');
if($s->idc){
	$st = $b->query("select email from cliente where email='$email' and id!='{$s->idc}' limit 1");
	if(!preg_match($emailRE,$email)){
		$x->m = '<img src="assets/img/out-cart.png" style="width:25px;margin-right:5px;margin-bottom:5px;float:left"/><div style="float:left;margin-top:3px;">E-mail inválido!</div>';
		$x->ok = 1;
	}elseif($st->rowCount()){
		$x->m = '<img src="assets/img/out-cart.png" style="width:25px;margin-right:5px;margin-top:15px;float:left"/><div style="float:left;margin-top:3px;">Email já cadastrado.<br>Cadastre outro email ou faça o login <a href="login">aqui</a>!</div>';
		$x->ok = 1;
	}
}else{
	$st = $b->query("select email from cliente where email='$email' limit 1");
	if(!preg_match($emailRE,$email)){
		$x->m = '<img src="assets/img/out-cart.png" style="width:25px;margin-right:5px;margin-bottom:5px;float:left"/><div style="float:left;margin-top:3px;">E-mail inválido!</div>';
		$x->ok = 1;
	}elseif($st->rowCount()){
		$x->m = '<img src="assets/img/out-cart.png" style="width:25px;margin-right:5px;margin-top:15px;float:left"/><div style="float:left;margin-top:3px;">Email já cadastrado.<br>Cadastre outro email ou faça o login <a href="login">aqui</a>!</div>';
		$x->ok = 1;
	}
}