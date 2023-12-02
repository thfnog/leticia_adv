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

		$rc = $b->query("select * from cart where idu='{$s->idc}' and s=1 order by id desc")->fetchObject();

		$valor_produtos = nreal($rc->v,'','.');
		$rc->vd = 0;//SEM DESCONTO
		$x->total = $rc->t - $rc->vd + $x->frete->val;//TOTAL SEM IMPOSTO

		$total = $x->total;
		if($pagamento=='erede'&&$s->idc==1)$x->imp = $x->imposto = 2.95;
		else $x->imp = $x->imposto = 0;
		$x->total = $total+$x->imposto;

//INÍCIO PAYPAL
		include 'class/vendor/PayPalLibrary/sendNvpRequest.php';
		$FORMA = $s->formasPagamento('paypal','sandbox');
		$sandbox = true;
		$user = $FORMA->email;
		$pswd = $FORMA->senha;
		$signature = $FORMA->paypalSign;
		if($sandbox)$paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
		else $paypalURL = 'https://www.paypal.com/cgi-bin/webscr';

		//Campos da requisição da operação SetExpressCheckout, como ilustrado acima.
		$frete = nreal($x->frete->val,'','.'); 
		$envio = $tipo==1?'PAC':($tipo==2?'SEDEX':($tipo==3?'ESEDEX':''));
		$url = "{$s->dom}{$s->dir}";
		if($rs->idd&&$rs->vd)$valor_produtos = $valor_produtos - $rs->vd;
		$requestNvp = array(
			'USER' => $user,
			'PWD' => $pswd,
			'SIGNATURE' => $signature,
			'VERSION' => '108.0',
			'METHOD'=> 'SetExpressCheckout',
			'PAYMENTREQUEST_0_PAYMENTACTION' => 'SALE',
			'PAYMENTREQUEST_0_AMT' => $total,
			'PAYMENTREQUEST_0_CURRENCYCODE' => 'BRL',
			'PAYMENTREQUEST_0_ITEMAMT' => $valor_produtos,
			'PAYMENTREQUEST_0_INVNUM' => uniqid(),//ID DO PEDIDO
			'PAYMENTREQUEST_0_SHIPPINGAMT' =>$frete,
			'PAYMENTREQUEST_0_SHIPTONAME' => $address_nome,
			'PAYMENTREQUEST_0_SHIPTOSTREET' => $address_rua,
			'PAYMENTREQUEST_0_SHIPTOCITY' => $address_city,
			'PAYMENTREQUEST_0_SHIPTOSTATE' => $address_uf,
			'PAYMENTREQUEST_0_SHIPTOZIP' => $address_cep,
			'SHIPPINGOPTIONNAME' => $envio,
			'RETURNURL' => $url.'retorno',
			'CANCELURL' => $url.'cancelamento',
			'BUTTONSOURCE' => 'BR_EC_EMPRESA',
		);

		$sth = $b->prepare("select a.*,p.id idp,p.h1 from cart_ax a left join produto p on a.idp=p.id where a.idc='{$rc->id}'");
		$sth->execute();
		$ra = $sth->fetchAll();
		foreach($ra as $k=>$v){
			$requestNvp['L_PAYMENTREQUEST_0_NAME'.$k] = addslashes($ra[$k]['h1']);
			$requestNvp['L_PAYMENTREQUEST_0_DESC'.$k] = addslashes($ra[$k]['h1']);
			$requestNvp['L_PAYMENTREQUEST_0_AMT'.$k] = $ra[$k]['v'];
			$requestNvp['L_PAYMENTREQUEST_0_QTY'.$k] = $ra[$k]['q'];
		}
		if($rs->idd&&$rs->vd){
			$qtd_item = $sth->rowCount();
			$requestNvp['L_PAYMENTREQUEST_0_NAME'.$qtd_item] = "Cupom de Desconto";
			$requestNvp['L_PAYMENTREQUEST_0_AMT'.$qtd_item] = -$rs->vd;
			$requestNvp['L_PAYMENTREQUEST_0_QTY'.$qtd_item] = 1;
		}
		$requestNvp['PAYMENTREQUEST_0_TAXAMT'] = nreal($x->imp,',','.');
		//Envia a requisição e obtém a resposta da PayPal
		$responseNvp = sendNvpRequest($requestNvp,$sandbox);
		//Se a operação tiver sido bem sucedida, redirecionamos o cliente para o
		//ambiente de pagamento.
		if(isset($responseNvp['ACK'])&&$responseNvp['ACK']=='Success'){
			$query = array(
				'cmd'    => '_express-checkout',
				'token'  => $responseNvp['TOKEN']
			);
			$redirectURL = sprintf('%s?%s', $paypalURL, http_build_query($query));
			$token = $responseNvp['TOKEN'];
			$idc = $rc->id;
			//$b->exec("update cart set s=2,da=now() where id=$idc limit 1");
			$cart_ax = $b->query("select count(*) as qp,sum(q) as qtd from cart_ax where idc='{$rc->id}'")->fetchObject();
			$b->exec("insert into pedido set statusPedido=1,forma='paypal',token_paypal='$token',transactionID='$payerID',dc=now(),idu={$s->idc},tf=$tipo,i='{$cart_ax->qp}',q='{$cart_ax->qtd}',v='{$rc->t}',f='{$x->frete->val}',t='$total',n='$address_nome',rua='$address_rua',num='$address_num',comp='$address_comp',bairro='$address_bairro',cep='$address_cep',city='$address_city',uf='$address_uf',t1='$t1',idc=$idc,w='{$rc->w}'");
			$id = $b->lastInsertId();
			$img = "{$s->base}upload/produtos/thumb/";
			$produtosEmail = checkout::setProduto($id,$img,$idc);

			require_once('class/email-pedido.php');
			$x->l = $redirectURL;
		}else{
			//$x->m = 'ERROS:'.$message.'-'.$total.'-'.$valor_produtos.'-'.$frete.'-'.$imposto;
			for($i=0;isset($responseNvp['L_ERRORCODE'.$i]);++$i){
					$message = sprintf("PayPal NVP %s[%d]: %s\n",
					$responseNvp['L_SEVERITYCODE'.$i],
					$responseNvp['L_ERRORCODE'.$i],
					$responseNvp['L_LONGMESSAGE'.$i]);
					error_log($message);
			}
			//$x->m = 'ERROS: '.$message.'-'.$total.'-'.$valor_produtos.'-'.$frete.'-'.$forma_envio.'-'.$imposto.' - '.$x->imp;
			$x->m = 'ERROS: '.$message;
			$x->a = $valor_produtos.' - '.$frete.' - '.$total.' - '.$x->imp;
			$x->erro = $requestNvp['PAYMENTREQUEST_0_ITEMAMT'].' - '.$requestNvp['PAYMENTREQUEST_0_SHIPPINGAMT'].' - '.$requestNvp['PAYMENTREQUEST_0_AMT'].' - '.$requestNvp['PAYMENTREQUEST_0_TAXAMT'].' - '.$requestNvp['L_PAYMENTREQUEST_0_NAME0'].' - '.$requestNvp['L_PAYMENTREQUEST_0_NAME1'];//
			$x->arequestNvp = $requestNvp;
			//$x->m = 'ERROS:'.$responseNvp['ACK'];
			//$b->query("update cart set da=now(),s=1 where id=$id and idu='{$s->idc}' limit 1");
		}

		$x->total = nreal($x->total);
		$x->freteVal = nreal($x->frete->val);
		$x->imposto = nreal($x->imposto);
		$x->tf = $tipo;
		$x->forma_envio = $tipo==1?'PAC':($tipo==2?'SEDEX':($tipo==3?'ESEDEX':''));
		$s->envio = $_SESSION['envio'] = $tipo;
		$s->pagamento = $_SESSION['pagamento'] = $pagamento;
		$x->ok = 1;
	}else{
		$x->m = $x->frete->m;
		$x->noopcoes = '<strong style="color:#7b0310">No momento não temos nenhuma opção de envio disponível.<br>Tente novamente em alguns instantes!</strong>';
	}
}