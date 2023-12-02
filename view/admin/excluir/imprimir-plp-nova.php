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

$params = include "controller/admin/criar-pre-lista.php";

$pdf = new \PhpSigep\Pdf\ListaDePostagem($params, time());
$pdf->render('I');
