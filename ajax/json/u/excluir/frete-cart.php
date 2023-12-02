<?php
$cep = strpr('cep');
//$cep = '13321-370';//REMOVER

if($_cep=preg_match($cepRE,$cep,$_m))$cep = "{$_m[1]}-{$_m[2]}";

if(!$cep)$x->m = 'Digite o CEP!';
elseif(!$_cep)$x->m = 'CEP inválido!';
else{
	$x->cep = $s->cep = $_SESSION['cep'] = $cep;
	$x->cli = $s->cep;
	$cookie_frete_cart = $_SESSION["cookie_cart"];
	if($s->idc)$rm = $b->query("select count(a.id) qtd,c.t from cart c left join cart_ax a on c.id=a.idc left join produto p on a.idp=p.id where c.idu='{$s->idc}' and c.s=1")->fetchObject();
	else $rm = $b->query("select count(a.id) qtd,c.t from cart_temp c left join cart_ax_temp a on c.id=a.idc left join produto p on a.idp=p.id where c.cookie='$cookie_frete_cart' and c.s=1")->fetchObject();
	$x->frete = $FRETE->cart();
	
	if($x->frete->ok){
		$x->m = 'Frete calculado com sucesso!';
		$x->ok = 1;
		if($s->FreteGratis&&$rm->t>=$s->FreteGratisValor)$x->freteGratis = 1;
	}else $x->m = $x->frete->m;
}
