<?php
require_once('class/restApi.php');
$id = strg('id',3);
$idc = strg('id_categoria',3);
$idm = strg('id_marca',3);
$n = strgs('nome');
$cod = strgs('codigo');
$ref = strgs('referencia');
$estoque = strgs('estoque');
$valor = strgs('valor');
$token = strgs('token');

if(!$token)$x->msg = 'O token é obrigatório!';
elseif($token!=$s->tokenApiData)$x->msg = 'Token inválido!';
elseif(!$id)$x->msg = 'O ID é obrigatório!';
elseif(!$n)$x->msg = 'O título é obrigatório!';
elseif(!$cod)$x->msg = 'O código é obrigatório!';
elseif(!isset($estoque))$x->msg = 'O estoque é obrigatório!';
elseif(!isset($valor))$x->msg = 'O valor é obrigatório!';
else{
	$x->return = restApi::insertProduto($id,$idc,$idm,$n,$cod,$estoque,$valor);
}