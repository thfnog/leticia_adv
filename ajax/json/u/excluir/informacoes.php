<?php
if($s->adm()){
	$id = 1;
	$frete = strp('frete',3)?1:0;
	$desconto = strp('desconto',3)?1:0;
	$vf = strps('vf');
	$vb = strps('vb');
	$vd = strps('vd');

	$rs = $b->query("select id from dados where id=$id limit 1")->fetchObject();

	if($id&&!$rs&&++$N)$x->m = 'Esta página não existe!';
	elseif($frete&&!$vf)$x->m = 'Digite o valor mínimo para frete grátis!';
	elseif(!isset($vb))$x->m = 'Digite a taxa do boleto!';
	elseif($desconto&&!$vd)$x->m = 'Digite o valor de desconto do boleto!';
	else{
		if($b->exec("update dados set frete=$frete,desconto=$desconto,vf='$vf',vb='$vb',vd='$vd' where id=$id limit 1")){
			$x->ok = 1;
			$x->m = 'Página alterada com sucesso!';
		}else $x->m = 'Nenhum campo para alterar!';
	}
}else $neg = true;