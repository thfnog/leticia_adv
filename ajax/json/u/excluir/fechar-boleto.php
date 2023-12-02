<?php
require_once('controller/topoCupom.php');

require_once('class/checkout.php');
$address = checkout::getAddress($opcao,$s->idc);

if($__t1=preg_match($telRE,$r->t1,$_t1))$r->t1 = "({$_t1[1]}) {$_t1[2]}-{$_t1[3]}";
if($__cep=preg_match($cepRE,$r->cep,$_cep))$r->cep = "{$_cep[1]}-{$_cep[2]}";

//if($opcao!=1)$x->m = 'Selecione o endereço principal!';
if(!$address->cep)$x->m = 'Digite o CEP!';
elseif(!$__cep)$x->m = 'CEP inválido!';
elseif(!$address->rua)$x->m = 'Digite o logradouro!';
elseif(!$address->sem_num&&!$address->num)$x->m = 'Digite o número ou selecione!';
elseif(!$address->bairro)$x->m = 'Digite o bairro!';
elseif(!$address->city)$x->m = 'Digite a cidade!';
elseif(!$address->uf)$x->m = 'Selecione o estado!';
elseif(!$tipo)$x->m = 'Selecione o tipo de entrega!';
elseif($se->rowCount())$x->m = 'Algum produto não encontra-se em estoque ou a quantidade em estoque é menor!';
elseif($rc->idd&&$rc->v<$ru->v)$x->m = "Para usar este cupom!\nO valor do pedido precisa de ser ao menos R$ {$ru->v}!";
elseif($rc->idd&&$ru->dv<$hj)$x->m = "O cupom expirou, atingiu seu limite de uso!\nRemova o Cupom!";
elseif($rc->idd&&$ru->q<=$ru->u)$x->m = 'O cupom atingiu seu limite de uso!';
elseif($rc->idd&&$rm->q>$ru->l)$x->m = 'Você já utilizou este cupom!';
elseif($rc->idd&&!$cupom->t=='NULL')$x->m = 'Os produtos que estão no carrinho não fazem parte deste cupom de desconto!';
else{
	$s->end = $_SESSION['end'] = '';
	$x->end = $s->end = $_SESSION['end'] = $address;
	//$x->cli = $s->end;
	$x->cep = $s->cep = $_SESSION['cep'] = $address->cep;
	$x->frete = $FRETE->checkout();
	if($x->frete->ok){
		$x->pac = $x->frete->pac;
		$x->sedex = $x->frete->sedex;
		$x->esedex = $x->frete->esedex;

		$x->valPac = nreal($x->pac);
		$x->valEsedex = nreal($x->esedex);
		$x->valSedex = nreal($x->sedex);
		if($tipo==1)$x->frete->val = $x->pac;
		elseif($tipo==2)$x->frete->val = $x->sedex;
		elseif($tipo==3)$x->frete->val = $x->esedex;
		else $x->frete->val = 0;

		$gratis = $b->query("select frete,vf,vb,desconto,vd from dados where id=1")->fetchObject();

		$rc->vd = $rc->vd?$rc->vd:0;//DESCONTO
		$x->total = $rc->t - $rc->vd + $gratis->vb + $x->frete->val;//TOTAL SEM IMPOSTO

		$total = $x->total;
		$tarifa_boleto = $gratis->vb;
		$desconto_cupom = $descontos = $rc->vd;
		$predesconto = $rc->t - $rc->vd;
		if($gratis->desconto)$descontototal = (($predesconto*$gratis->vd)/100);
		else $descontototal = 0;
		$descontos = $rc->vd + $descontototal;
		if($pagamento=='erede'&&$s->idc==1)$x->imp = $x->imposto = 2.95;
		else $x->imp = $x->imposto = 0;
		$total = $total - $descontototal;
		$x->total = $total+$x->imposto;

//INÍCIO BOLETO
		try{
			$idc = $rc->id;
			$id_cupom = $rc->idd;
			$cod_cupom = $ru->c;
			$b->exec("update cart set s=2,da=now() where id=$idc limit 1");
			$cart_ax = $b->query("select count(*) as qp,sum(q) as qtd from cart_ax where idc='{$rc->id}'")->fetchObject();
			$b->exec("insert into pedido set forma='$pagamento',dc=now(),idu={$s->idc},idd='$id_cupom',cod_cupom='$cod_cupom',tf=$tipo,i='{$cart_ax->qp}',q='{$cart_ax->qtd}',v='{$rc->t}',f='{$x->frete->val}',tarifa_boleto='$tarifa_boleto',t='$total',vd='$descontos',desconto_boleto='$descontototal',desconto_cupom='$desconto_cupom',n='$address_nome',rua='$address_rua',num='$address_num',comp='$address_comp',bairro='$address_bairro',cep='$address_cep',city='$address_city',uf='$address_uf',t1='{$x->t1}',idc=$idc,w='{$rc->w}'");
			$id = $b->lastInsertId();
			$img = "{$s->base}upload/produtos/thumb/";
			$produtosEmail = checkout::setProduto($id,$img,$idc);

			include 'class/ItauLibrary/itaucripto.php';
			$cripto = new Itaucripto;

			$codEmp = "J0028442380001290000028552";//CÓDIGO DO SITE
			$pedido = $id;//ID DO PEDIDO
			$valor = nreal($total);//VALOR DO PEDIDO USAR VÍRGULA COMO SEPARADOR DE CASAS
			$observacao = "";//OBS
			$chave = "S1m2k3t4w5s6p7o8";//CHAVE
			$nomeSacado = $address_nome;
			$codigoInscricao = $tipo_cpf_cnpj;//CÓDIGO DO SACADO 01-CPF/02-CNPJ
			$numeroInscricao = $cpf_cnpj;//CPF OU CNPJ
			$enderecoSacado = $address_rua.", ".$address_num;
			$bairroSacado = $address_bairro;
			$cepSacado = $address_cep;
			$cepSacado = str_replace(".","",$cepSacado);
			$cepSacado = str_replace("-","",$cepSacado);
			$cidadeSacado = $address_city;
			$estadoSacado = $address_uf;
			$dataVencimento = date("dmY",strtotime("+1 day"));
			//$urlRetorna = "http://localhost/cica/retorno-boleto";
			//$url = "{$s->base}";
			$url = "{$_SERVER['HTTP_HOST']}{$s->dir}";
			$urlRetorna = $url."obrigado/".$id;
			$obsAd1 = "";
			$obsAd2 = "";
			$obsAd3 = "";
			
			$dados = $cripto->geraDados($codEmp,$pedido,$valor,$observacao,$chave,$nomeSacado,$codigoInscricao,$numeroInscricao,$enderecoSacado,$bairroSacado,$cepSacado,$cidadeSacado,$estadoSacado,$dataVencimento,$urlRetorna,$obsAd1,$obsAd2,$obsAd3);
			
			$x->ok = 1;
			$x->boleto = 1;
			$x->dados = $dados;

			require_once('class/email-pedido.php');
			if($rc->idd)$b->query("update cupom set u=u+1 where id='{$rc->idd}' limit 1");
		}catch(Exception $e){
			$x->m = $e->getMessage();
			die($e->getMessage());
		}
//FIM PAGSEGURO

		$x->total = nreal($x->total);
		$x->freteVal = nreal($x->frete->val);
		$x->imposto = nreal($x->imposto);
		$x->tf = $tipo;
		$x->forma_envio = $tipo==1?'PAC':($tipo==2?'SEDEX':($tipo==3?'ESEDEX':''));
		$s->envio = $_SESSION['envio'] = $tipo;
		$s->pagamento = $_SESSION['pagamento'] = $pagamento;
		$x->boleto = 1;
		$x->ok = 1;
	}else{
		$x->m = $x->frete->m;
		$x->noopcoes = '<strong style="color:#7b0310">No momento não temos nenhuma opção de envio disponível.<br>Tente novamente em alguns instantes!</strong>';
	}
}