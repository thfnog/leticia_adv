<?php
require_once('class/restApi.php');
$table = strgs('table');
$id = strg('id',3);
$table = 'cat';
$token = strgs('token');

if(!$token)$x->msg = 'O token é obrigatório!';
elseif($token!=$s->tokenApiData)$x->msg = 'Token inválido!';
elseif(!$table)$x->msg = 'A tabela é obrigatória!';
elseif($table!='cat')$x->msg = 'Tabela inválida!';
elseif(!$id)$x->msg = 'O ID é obrigatório!';
else{
	$x->return = restApi::insertAll($table);
}