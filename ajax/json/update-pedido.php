<?php
require_once('class/restApi.php');
$id = strg('id',3);
$token = strgs('token');

if(!$token)$x->msg = 'O token é obrigatório!';
elseif($token!=$s->tokenApiData)$x->msg = 'Token inválido!';
elseif(!$id)$x->msg = 'O ID é obrigatório!';
else $x->return = restApi::updatePedido($id);