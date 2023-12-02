<?php
require_once('class/restApi.php');
$table = strgs('table');
$id = strg('id',3);
$token = strgs('token');

if(!$token)$x->msg = 'O token é obrigatório!';
elseif($token!=$s->tokenApiData)$x->msg = 'Token inválido!';
elseif(!$table)$x->msg = 'A tabela é obrigatória!';
elseif($table!='produto'&&$table!='pedido'&&$table!='cat')$x->msg = 'Você pode consultar apenas as tabelas produto, pedido e categoria!';
else{
	if($table=='produto')$fields = "id id_produto,c cod,n titulo";
	elseif($table=='pedido'){
		$fields = "pedido.id id_pedido,pedido.idu id_cliente,pedido.idd id_cupom,pedido.cod_cupom,pedido.cod cod_rastreio,pedido.forma,pedido.i qtd_itens,pedido.q qtd_soma,pedido.v valor,pedido.dp desconto_porcentagem,pedido.df desconto_fixo,pedido.desconto_boleto,pedido.desconto_cupom,pedido.vd desconto_total,pedido.f valor_frete,pedido.t total,pedido.tarifa_boleto,pedido.imposto,pedido.w peso,pedido.tf tipo_frete,pedido.n nome,pedido.cep,pedido.rua,pedido.num,pedido.bairro,pedido.city cidade,pedido.uf,pedido.comp complemento,pedido.t1 telefone,pedido.parcelas,pedido.importado,cliente.email,cliente.cnpj,cliente.cpf";
		$join = " inner join cliente on pedido.idu=cliente.id";
	}
	else $fields = "*";
	if($id){
		if($table=='pedido'){
			$x->return = restApi::read($table,"pedido.id=$id and pedido.importado=0",$fields,$join);
			if($x->return!=false){
				$join = " inner join produto p on a.idp=p.id";
				$x->detalhesPedido = restApi::readDetalhes($table.'_ax a',"a.idc=".$id,$join);
			}
		}else{
			$x->return = restApi::read($table,"id=$id",$fields);	
		}
	}else{
		if($table=='pedido')$x->return = restApi::readAll($table,"pedido.importado=0",$fields,$join);
		else $x->return = restApi::readAll($table,0,$fields);
	}
}