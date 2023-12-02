<?php
$medida = $b->query($sql="select max(p.altura) altura,max(p.comprimento) comprimento,max(p.largura) largura from pedido c left join pedido_ax a on c.id=a.idc left join produto p on a.idp=p.id where c.id=$id")->fetchObject();
$comprimento = $medida->comprimento;
$altura = $medida->altura;
$largura = $medida->largura;
$peso = $rs->w;
$nome = $rs->n;
$rua = $rs->rua;
$cep = $rs->cep;
$num = $rs->num;
$bairro = $rs->bairro;
$comp = $rs->comp;
$city = $rs->city;
$uf = $rs->uf;

$params = include "controller/admin/criar-pre-lista-a4.php";

// Logo da empresa remetente
$logoFile = "{$s->base}assets/img/logo-etiqueta-2016.png";

//Parametro opcional indica qual layout utilizar para a chancela. Ex.: CartaoDePostagem::TYPE_CHANCELA_CARTA, CartaoDePostagem::TYPE_CHANCELA_CARTA_2016
//$layoutChancela = array(); //array(\PhpSigep\Pdf\CartaoDePostagem2016::TYPE_CHANCELA_SEDEX_2016);
if($forma=='pac')$layoutChancela = array(\PhpSigep\Pdf\CartaoDePostagem2016::TYPE_CHANCELA_PAC_2016);
else $layoutChancela = array(\PhpSigep\Pdf\CartaoDePostagem2016::TYPE_CHANCELA_SEDEX_2016);

if(!$rs->etiquetaGerada)$b->query("update pedido set etiquetaGerada=1 where id=$id limit 1");

if(!$rs->plp){
	$pdf = new \PhpSigep\Pdf\CartaoDePostagem2016($params, time(), $logoFile, $layoutChancela);
	$s->loc("admin/pedido/$id");
}else{
	$pdf = new \PhpSigep\Pdf\CartaoDePostagem2016($params, $rs->plp, $logoFile, $layoutChancela);
	$pdf->render();
}