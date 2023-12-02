<?php
require_once('class/restApi.php');
$table = strgs('table');
$id = strg('id',3);
$token = strgs('token');

if(!$token)$x->msg = 'O token é obrigatório!';
elseif($token!=$s->tokenApiData)$x->msg = 'Token inválido!';
elseif(!$table)$x->msg = 'A tabela é obrigatória!';
elseif($table!='produto'&&$table!='cat')$x->msg = 'Você pode deletar dados apenas das tabelas produto e categoria!';
elseif(!$id)$x->msg = 'O ID é obrigatório!';
else $x->return = restApi::delete($table,$id);