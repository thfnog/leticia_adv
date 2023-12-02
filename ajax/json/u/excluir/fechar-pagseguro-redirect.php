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

//INÍCIO PAGSEGURO
		$AMBIENTE = $s->idc==1?'sandbox':'production';
		$FORMA = $s->formasPagamento('pagseguro',$AMBIENTE);//production or sandbox
		define("AMBIENTE_PAGSEGURO",$FORMA->ambiente);
		define("EMAIL_PAGSEGURO",$FORMA->email);
		define("TOKEN_PAGSEGURO",$FORMA->token);

		require_once "class/vendor/autoload.php";

		\PagSeguro\Library::initialize();
		\PagSeguro\Library::cmsVersion()->setName("Nome")->setRelease("1.0.0");
		\PagSeguro\Library::moduleVersion()->setName("Nome")->setRelease("1.0.0");
		$payment = new \PagSeguro\Domains\Requests\Payment();

		$sa = $b->query("select a.*,p.id idp,p.h1 from cart_ax a left join produto p on a.idp=p.id where a.idc='{$rc->id}'");
		while($ra=$sa->fetchObject()){
			$payment->addItems()->withParameters($ra->idp,strs($ra->h1),$ra->q,$ra->v);
		}

		$payment->setCurrency("BRL");
		$payment->setSender()->setName($address->nome);
		if($s->idc==1)$address->email = "c33674267883419552031@sandbox.pagseguro.com.br";//SENHA: 4Yd2DEfm8W0v6h5c
		$payment->setSender()->setEmail($address->email);
		$payment->setSender()->setPhone()->withParameters($address->ddd,$address->t1);
		$payment->setSender()->setDocument()->withParameters($address->tipo_cpf_cnpj,$address->cpf_cnpj);
		$payment->setShipping()->setAddress()->withParameters($address->rua,$address->num,$address->bairro,$address->cep,$address->city,$address->uf,'BRA',$address->comp);
		if($rc->vd)$payment->setExtraAmount(-$rc->vd);
		$payment->setShipping()->setCost()->withParameters($x->frete->val);
		$payment->setShipping()->setType()->withParameters($tipo);
		$url = "{$s->dom}{$s->dir}";
		try{
			$idc = $rc->id;
			if($s->idc!=1)$b->exec("update cart set s=2,da=now() where id=$idc limit 1");
			$cart_ax = $b->query("select count(*) as qp,sum(q) as qtd from cart_ax where idc='{$rc->id}'")->fetchObject();
			$b->exec("insert into $tabelaPedido set statusPagseguro=1,statusPedido=1,forma='pagseguro',dc=now(),idu={$s->idc},idd='{$rc->idd}',cod_cupom='{$ru->c}',tf=$tipo,i='{$cart_ax->qp}',q='{$cart_ax->qtd}',v='{$rc->t}',f='{$x->frete->val}',t='$total',vd='{$rc->vd}',n='{$address->nome}',rua='{$address->rua}',num='{$address->num}',comp='{$address->comp}',bairro='{$address->bairro}',cep='{$address->cep}',city='{$address->city}',uf='{$address->uf}',t1='$t1',idc=$idc,w='{$rc->w}'");
			$id = $b->lastInsertId();
			$payment->setRedirectUrl($url."obrigado");
			$payment->setNotificationUrl($url."notification-pagseguro/".$id);
			$payment->setReference($id);
			if($s->idc!=1)$produtosEmail = checkout::setProduto($id,$img,$idc);

			if($s->idc!=1)require_once('class/email-pedido.php');
			$result = $payment->register(\PagSeguro\Configuration\Configure::getAccountCredentials());
			if($rc->idd)$b->query("update cupom set u=u+1 where id='{$rc->idd}' limit 1");
			$x->l = $result;
		}catch(Exception $e){
			$b->exec("update cart set s=1,da=now() where id=$idc limit 1");
			$x->m = $e->getMessage();
			return false;
			//die($e->getMessage());
		}
//FIM PAGSEGURO

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