<?
if(true){
	require_once('controller/topoCupom.php');

	if($opcao==1){
		$rfrete = $b->query("select tp,n,r,t1,email,cpf,cnpj,cep,rua,num,sem_num,comp,bairro,city,uf from cliente where id={$s->idc} limit 1")->fetchObject();
		$x->tp = $rfrete->tp;
		$x->n = $r->n = $rfrete->tp==1?$rfrete->n:$rfrete->r;
		$x->t1 = $r->t1 = $rfrete->t1;
		if($_t1=preg_match($telRE,$x->t1,$_m)){
			$x->t1 = $r->t1 = $t1 = "{$_m[2]}{$_m[3]}";
			$x->ddd = "{$_m[1]}";
		}
		if($_cpf=preg_match($cpfRE,$rfrete->cpf,$_m))$cpf = "{$_m[1]}{$_m[2]}{$_m[3]}{$_m[4]}";
		if($_cnpj=preg_match($cnpjRE,$rfrete->cnpj,$_m))$cnpj = "{$_m[1]}.{$_m[2]}.{$_m[3]}/{$_m[4]}-{$_m[5]}";
		$cpf_cnpj = $rfrete->tp==1?$cpf:$cnpj;
		$tipo_cpf_cnpj = $rfrete->tp==1?'cpf':'cnpj';
		$nome_razao = $rfrete>tp=='1'?'Nome':'Razão Social';
		$x->email = $r->email = $rfrete->email;
		$x->cep = $r->cep = $rfrete->cep;
		$x->rua = $r->rua = $rfrete->rua;
		$x->num = $r->num = $rfrete->num;
		$x->sem_num = $r->sem_num = $rfrete->sem_num;
		$x->comp = $r->comp = $rfrete->comp;
		$x->bairro = $r->bairro = $rfrete->bairro;
		$x->city = $r->city = $rfrete->city;
		$r->tcity = tag($r->city,1);
		$x->uf = $r->uf = $rfrete->uf;	
		$address_nome = strs($r->n);
		$address_email = strs($r->email);
		$address_rua = strs($r->rua);
		$address_num = strs($r->num);
		$address_bairro = strs($r->bairro);
		$address_city = strs($r->city);
		$address_cep = strs($r->cep);
		$address_uf = strs($r->uf);
		$address_comp = strs($r->comp);
		$address_t1 = strs($r->t1);
	}elseif($opcao==2){
		$rfrete = $b->query("select tp,n,r,t1,email,cpf,cnpj from cliente where id={$s->idc} limit 1")->fetchObject();
		$x->tp = $rfrete->tp;
		$x->n = $r->n = $rfrete->tp==1?$rfrete->n:$rfrete->r;
		$x->t1 = $r->t1 = $rfrete->t1;
		if($_t1=preg_match($telRE,$x->t1,$_m)){
			$x->t1 = $r->t1 = $t1 = "{$_m[2]}{$_m[3]}";
			$x->ddd = "{$_m[1]}";
		}
		if($_cpf=preg_match($cpfRE,$rfrete->cpf,$_m))$cpf = "{$_m[1]}{$_m[2]}{$_m[3]}{$_m[4]}";
		if($_cnpj=preg_match($cnpjRE,$rfrete->cnpj,$_m))$cnpj = "{$_m[1]}.{$_m[2]}.{$_m[3]}/{$_m[4]}-{$_m[5]}";
		$cpf_cnpj = $rfrete->tp==1?$cpf:$cnpj;
		$tipo_cpf_cnpj = $rfrete->tp==1?'CPF':'CNPJ';
		$nome_razao = $rfrete>tp=='1'?'Nome':'Razão Social';
		$cep = strps('ncep');
		$rua = strps('nrua');
		$num = strps('nnum');
		$sem_num = strp('nsem_num',3)?1:0;
		$comp = strps('ncomp');
		$bairro = strps('nbairro');
		$city = strps('ncity');
		$cityt = tag($city,1);
		$uf = strps('nuf');
		$x->cep = $r->cep = $cep;
		$x->rua = $r->rua = $rua;
		$x->num = $r->num = $num;
		$x->sem_num = $r->sem_num = $sem_num;
		$x->comp = $r->comp = $comp;
		$x->bairro = $r->bairro = $bairro;
		$x->city = $r->city = $city;
		$r->tcity = tag($r->city,1);
		$x->uf = $r->uf = $uf;
		$address_nome = strs($r->n);
		$address_rua = $rua;
		$address_num = $num;
		$address_bairro = $bairro;
		$address_city = $city;
		$address_cep = $cep;
		$address_uf = $uf;
		$address_comp = $comp;
		$address_t1 = $t1;
	}

	//VARS EMAIL
	$topo = "{$s->base}img/email/topo.jpg";
	$rodape = "{$s->base}img/email/rodape.jpg";
	$img = "{$s->base}upload/produtos/thumb/";
	$site = "{$s->base}";
	$base_frete = "{$s->base}img/frete/";
	$base_pagamento = "{$s->base}img/pagamentos/";
	//VARS EMAIL

	if($__t1=preg_match($telRE,$r->t1,$_t1))$r->t1 = "({$_t1[1]}) {$_t1[2]}-{$_t1[3]}";
	if($__cep=preg_match($cepRE,$r->cep,$_cep))$r->cep = "{$_cep[1]}-{$_cep[2]}";

	//if($opcao!=1)$x->m = 'Selecione o endereço principal!';
	if(!$r->cep)$x->m = 'Digite o CEP!';
	elseif(!$__cep)$x->m = 'CEP inválido!';
	elseif(!$r->rua)$x->m = 'Digite o logradouro!';
	elseif(!$r->sem_num&&!$r->num)$x->m = 'Digite o número ou selecione!';
	elseif(!$r->bairro)$x->m = 'Digite o bairro!';
	elseif(!$r->city)$x->m = 'Digite a cidade!';
	elseif(!$r->uf)$x->m = 'Selecione o estado!';
	elseif(!$tipo)$x->m = 'Selecione o tipo de entrega!';
	else{
		$url = "{$_SERVER['HTTP_HOST']}{$s->dir}";
		$s->end = $_SESSION['end'] = '';
		$x->end = $s->end = $_SESSION['end'] = $address;
		//$x->cli = $s->end;
		$x->cep = $s->cep = $_SESSION['cep'] = $r->cep;
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

			$rc->vd = 0;//SEM DESCONTO
			$x->total = $rc->t - $rc->vd + $x->frete->val;//TOTAL SEM IMPOSTO

			$total = $x->total;
			if($pagamento=='erede'&&$s->idc==1)$x->imp = $x->imposto = 2.95;
			else $x->imp = $x->imposto = 0;
			$x->total = $total+$x->imposto;

//INÍCIO REDE PAY
			require_once "redepay/autoload.php";

			$apiKey = '';

			$RedePay = new \RedePay\RedePay($apiKey);

			
			/* Shipping */
			$address = new \RedePay\Address\Address();
			//$address->setAlias("Comercial");
			$address->setStreet($address_rua);
			$address->setNumber($address_num);
			$address->setComplement($address_comp);
			$address->setPostalCode($address_cep);//SÓ NÚMERO
			$address->setDistrict($address_bairro);
			$address->setCity($address_city);
			$address->setState($address_uf);
			
			$shipping = new \RedePay\Shipping\Shipping();
			$shipping->setCost($x->frete->val);//SÓ NÚMERO
			$shipping->setAddress($address);

			/* Items */
			$item = new \RedePay\Item\Item();
			$sa = $b->query("select a.*,p.id idp,p.h1 from cart_ax a left join produto p on a.idp=p.id where a.idc='{$rc->id}'");
			while($ra=$sa->fetchObject()){
				$item->setId($ra->idp);
				$item->setAmount($ra->v);
				$item->setQuantity($ra->q);
				//$item->setDiscount(50000);//DESCONTO
				$item->setDescription(strs($ra->h1));
				//$item->setFreight(5000);//FRETE
			}
			
			$items = array();
			$items[] = $item;			

			/* Customer */
			$cellphone = new \RedePay\Phone\Phone();
			$cellphone->setKind("cellphone");
			$cellphone->setNumber($x->ddd.$x->t1);
			$phones = array();
			$phones[] = $cellphone;
			
			$document = new \RedePay\Document\Document();
			$document->setKind($tipo_cpf_cnpj);
			$document->setNumber($cpf_cnpj);
			$documents = array();
			$documents[] = $document;
			
			$customer = new \RedePay\Customer\Customer();
			$customer->setName($address_nome);
			$customer->setEmail($address_email);
			$customer->setPhones($phones);
			$customer->setDocuments($documents);

			try{
				$idc = $rc->id;
				$b->exec("update cart set s=2,da=now() where id=$idc limit 1");
				$cart_ax = $b->query("select count(*) as qp,sum(q) as qtd from cart_ax where idc='{$rc->id}'")->fetchObject();
				$b->exec("insert into pedido set statusPagseguro=1,statusPedido=1,dc=now(),idu={$s->idc},tf=$tipo,i='{$cart_ax->qp}',q='{$cart_ax->qtd}',v='{$rc->t}',f='{$x->frete->val}',t='$total',n='$address_nome',rua='$address_rua',num='$address_num',comp='$address_comp',bairro='$address_bairro',cep='$address_cep',city='$address_city',uf='$address_uf',t1='$t1',idc=$idc,w='{$rc->w}'");
				$id = $b->lastInsertId();

				/* Urls */
				/* define a URL para qual o comprador será direcionado após concluir a compra */
				$redirect = new \RedePay\Url\Url();
				$redirect->setKind("redirect");
				$redirect->setUrl($url."obrigado/".$id);
				
				/* define a URL para qual o comprador será direcionado após cancelar a compra */
				$cancel = new \RedePay\Url\Url();
				$cancel->setKind("cancel");
				$cancel->setUrl($url."cancelar/".$id);
	
				/* define a URL para qual a loja receberá callbacks de alterações status das transações */
				$notification = new \RedePay\Url\Url();
				$notification->setKind("notification");
				$notification->setUrl($url."notification/".$id);
	
				/* define a URL para qual a loja receberá callbacks de alterações status dos pedidos */
				$orderNotification = new \RedePay\Url\Url();
				$orderNotification->setKind("orderNotification");
				$orderNotification->setUrl($url."order-notification/".$id);
	
				$urls = array();
				$urls[] = $redirect;
				$urls[] = $cancel;
				$urls[] = $notification;
				$urls[] = $orderNotification;

				$sa = $b->query("select a.*,p.id idp,p.itm,p.h1,p.t tag from cart_ax a left join produto p on a.idp=p.id where a.idc='{$rc->id}'");
				while($ra=$sa->fetchObject()){
					$w = $ra->q * $ra->p;
					$totals = $ra->v * $ra->q;
					$b->exec("insert into pedido_ax set idc=$id,idp='{$ra->idp}',q='{$ra->q}',v='{$ra->v}',t='{$ra->t}',p='{$ra->p}',w='$w'");
					$link = "{$s->base}produto/".$ra->idp."/".$ra->tag;
					$produtosEmail.= '<tr>
						<td width="65" valign="middle" align="center" style="background:#fff">
							<a href="'.$link.'"><img src="'.$img.$ra->itm.'" alt="'.$ra->h1.'" data-default="placeholder" width="60" height="72"></a>
						</td>
						<td valign="middle" style="background:#fff;padding:10px;text-align:center">
							<div class="contentEditableContainer contentTextEditable">
								<div class="contentEditable">
									<a href="'.$link.'"><h2>'.strh($ra->h1).'</h2></a>
								</div>
							</div>
						</td>
						<td valign="middle" style="background:#fff;padding:10px;text-align:center">
							<div class="contentEditableContainer contentTextEditable">
								<div class="contentEditable">
									<h2>'.strh($ra->q).'</h2>
								</div>
							</div>
						</td>
						<td valign="middle" style="background:#fff;padding:10px;text-align:center">
							<div class="contentEditableContainer contentTextEditable">
								<div class="contentEditable">
									<h2>R$ '.nreal($ra->v).'</h2>
								</div>
							</div>
						</td>
						<td valign="middle" style="background:#fff;padding:10px;text-align:center">
							<div class="contentEditableContainer contentTextEditable">
								<div class="contentEditable">
									<h2>R$ '.nreal($totals).'</h2>
								</div>
							</div>
						</td>
					</tr>';
				}
				require_once('class/email-pedido.php');
				//$result = $payment->register(\PagSeguro\Configuration\Configure::getAccountCredentials());
				$order = new \RedePay\Order\Order();
				$order->setReference($id); 
				//$order->setDiscount($rc->vd); //DESCONTO
				$order->setShipping($shipping);
				$order->setItems($items);
				$order->setCustomer($customer);
				$order->setSettings($settings);
				$order->setUrls($urls);
				
				$newOrder = $RedePay->order()->create($order);
				//$x->l = $newOrder;
				$x->retorno = $newOrder;
			}catch(Exception $e){
				$x->m = $e->getMessage();
				die($e->getMessage());
			}
//FIM REDE PAY

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
}else $neg = true;
?>