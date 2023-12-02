<?php
require_once('class/restApi.php');
$id = strg('id',3);
$n = strgs('nome');
$token = strgs('token');

if(!$token)$x->msg = 'O token é obrigatório!';
elseif($token!=$s->tokenApiData)$x->msg = 'Token inválido!';
elseif(!$id)$x->msg = 'O ID é obrigatório!';
elseif(!$n)$x->msg = 'O nome é obrigatório!';
else{
	$x->return = restApi::insertCat($id,$n);
}