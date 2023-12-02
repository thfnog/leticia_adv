<?php
require_once('controller/topoCupom.php');

require_once('class/checkout.php');
$address = checkout::getAddress($opcao,$s->idc);

if($__t1=preg_match($telRE,$r->t1,$_t1))$r->t1 = "({$_t1[1]}) {$_t1[2]}-{$_t1[3]}";
if($__cep=preg_match($cepRE,$address->cep,$_cep))$address->cep = "{$_cep[1]}-{$_cep[2]}";

require_once('controller/topoValidacoes.php');
if($noErrors==1){
	$s->end = $_SESSION['end'] = '';
	$x->end = $s->end = $_SESSION['end'] = $address;
	$x->cep = $s->cep = $_SESSION['cep'] = $address->cep;
	$x->frete = $FRETE->checkout();
	if($x->frete->ok){
		require_once('controller/topoValores.php');

//INÍCIO PAGHIPER
		require_once('class/pagHiper.php');
		$AMBIENTE = 'production';
		$FORMA = $s->formasPagamento('paghiper',$AMBIENTE);//production or sandbox

		$data = array();
		
		$data['apiKey'] = $FORMA->paghiperApiKey;
		$data['payer_email'] = $address->email;
		$data['payer_name'] = $address->nome;
		$data['payer_cpf_cnpj'] = $address->cpf_cnpj;
		$data['payer_phone'] = $address->tel;
		$data['payer_street'] = $address->rua;
		$data['payer_number'] = $address->num;
		$data['payer_complement'] = $address->comp;
		$data['payer_district'] = $address->bairro;
		$data['payer_city'] = $address->city;
		$data['payer_state'] = $address->uf;
		$data['payer_zip_code'] = $address->cep;
		if($rc->vd)$data['discount_cents'] = $rc->vd*100;//Em centavos
		$data['shipping_price_cents'] = $x->frete->val*100;
		$data['shipping_methods'] = $tipo==1?'PAC':'SEDEX';
		$data['fixed_description'] = true;
		$data['type_bank_slip'] = 'boletoA4';
		$data['days_due_date'] = '2';//Dias para vencimento do boleto
		$data['late_payment_fine'] = '2';//Percentual de multa após vencimento.
		$data['per_day_interest'] = true;//Juros após vencimento.

		$key = 0;
		$sa = $b->query("select a.*,p.id idp,p.h1 from cart_ax a left join produto p on a.idp=p.id where a.idc='{$rc->id}'");
		while($ra=$sa->fetchObject()){
			$data['items'][$key]['description'] = strs($ra->h1);
			$data['items'][$key]['quantity'] = $ra->q;
			$data['items'][$key]['item_id'] = $ra->idp;
			$data['items'][$key]['price_cents'] = $ra->v*100;
			$key++;
		}
		$url = "{$s->dom}{$s->dir}";
		try{
			$idc = $rc->id;
			$b->beginTransaction();
			if($s->idc!=1)$b->exec("update cart set s=2,da=now() where id=$idc limit 1");
			$cart_ax = $b->query("select count(*) as qp,sum(q) as qtd from cart_ax where idc='{$rc->id}'")->fetchObject();
			$b->exec("insert into $tabelaPedido set statusPagseguro=1,statusPedido=1,forma='paghiper',tipoCartao='boleto',dc=now(),idu={$s->idc},idd='{$rc->idd}',cod_cupom='{$ru->c}',tf=$tipo,i='{$cart_ax->qp}',q='{$cart_ax->qtd}',v='{$rc->t}',f='{$x->frete->val}',t='$total',vd='{$rc->vd}',n='{$address->nome}',rua='{$address->rua}',num='{$address->num}',comp='{$address->comp}',bairro='{$address->bairro}',cep='{$address->cep}',city='{$address->city}',uf='{$address->uf}',t1='$t1',idc=$idc,w='{$rc->w}'");
			$id = $b->lastInsertId();
			$data['order_id'] = $id;
			$data['notification_url'] = $url."notification-paghiper/".$id;
			$result = $PAGHIPER->gerarBoleto($data);
			$transactionID = $result['create_request']['transaction_id'];
			$x->paymentLink = $url_slip = $result['create_request']['bank_slip']['url_slip'];
			if($s->idc!=1)$produtosEmail = checkout::setProduto($id,$img,$idc);

			if($s->idc!=1)require_once('class/email-pedido.php');
			if($rc->idd)$b->query("update cupom set u=u+1 where id='{$rc->idd}' limit 1");
			$b->commit();
		}catch(Exception $e){
			$b->exec("update cart set s=1,da=now() where id=$idc limit 1");
			$x->m = $result;
			$b->rollBack();
			$b->exec("ALTER TABLE $tabelaPedido AUTO_INCREMENT = $id");
			return false;
		}
		$b->query("update $tabelaPedido set transactionID='$transactionID',paymentLink='{$x->paymentLink}' where id=$id");
		$x->l = 'obrigado';
//FIM PAGHIPER

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