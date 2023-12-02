<?
use erede\model\EnvironmentType;
use erede\model\TransactionKind;
use erede\model\TransactionRequest;
use erede\model\IataRequest;
use erede\model\ThreeDSecureRequest;
use erede\model\UrlRequest;
use erede\model\UrlKind;
use erede\model\AvsRequest;
use erede\model\AddressRequest;
use erede\model\ThreeDSecureOnFailure;

if(true){
	unset($r);
	$tipo = strg('tipo',3);
	if(is_array($tipo))$tipo = (int)implode('', $tipo);
	$s->idc = strg('idc',3);
	$pagamento = strgs('pagamento');
	if(is_array($pagamento))$pagamento = (int)implode('', $pagamento);
	$x->pagamento = $pagamento;
	$opcao = strg('opcao',3);
	if(is_array($opcao))$opcao = (int)implode('', $opcao);

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

	$cardType = strgs('cardType');
	//VARS CREDIT CARD
	$x->cardNumber = $cardNumber = strgs('cardNumber');
	if($cardNumber)$cardNumber = str_replace(' ','',$cardNumber);
	$cardName = strgs('cardName');
	$cardExpiry = strgs('cardExpiry');
	$cardMonth = (int)substr($cardExpiry,0,2);
	$cardYear = (int)substr($cardExpiry,-2);
	$cardCVC = strgs('cardCVC');
	$cardInstallments = strg('cardInstallments',3);
	//VARS CREDIT CARD

	//VARS DEBIT CARD
	$debitNumber = trim(strgs('debitNumber'));
	if($debitNumber)$debitNumber = str_replace(' ','',$debitNumber);
	$debitName = strgs('debitName');
	$debitExpiry = strgs('debitExpiry');
	$debitMonth = (int)substr($debitExpiry,0,2);
	$debitYear = (int)substr($debitExpiry,-2);
	$debitCVV = strgs('debitCVV');;
	//VARS DEBIT CARD

	if($__t1=preg_match($telRE,$r->t1,$_t1))$r->t1 = "({$_t1[1]}) {$_t1[2]}-{$_t1[3]}";
	if($__cep=preg_match($cepRE,$r->cep,$_cep))$r->cep = "{$_cep[1]}-{$_cep[2]}";

	require_once('class/validaCartao.php');
	$validaCartao = new validaCartao();
	if($x->cardNumber)$cardValidate = $validaCartao->creditCard($x->cardNumber);

	$rc = $b->query("select * from cart where idu='{$s->idc}' and s=1 order by id desc")->fetchObject();
	$se = $b->query("select c.*,p.estoque from cart_ax c left join produto p on c.idp=p.id where c.idc='{$rc->id}' and p.estoque<c.q");
	$ru = $b->query("select * from cupom where id='{$rc->idd}' limit 1")->fetchObject();
	$rm = $b->query("select count(idd) as q from pedido where idu='{$s->idc}' and idd='{$ru->id}'")->fetchObject();
	if($ru->tipo_cupom=='produto'){
		$cupom = $b->query("select sum(t) t from (select a.t t from cart_ax a left join cart c on a.idc=c.id left join cupom_ax u on a.idp=u.idp where a.idc='{$rc->id}' and u.idc='{$ru->id}' group by a.idp) t1")->fetchObject();
	}elseif($ru->tipo_cupom=='produtos'){
		$cupom = $b->query("select sum(t) t from(select a.t t from cart_ax a left join cart c on a.idc=c.id left join cupom u on c.idd=u.id where a.idc='{$rc->id}' group by a.idp) t1")->fetchObject();
	}elseif($ru->tipo_cupom=='categoria'){
		$cupom = $b->query("select sum(t) t from (select a.t t from cart_ax a left join cart c on a.idc=c.id left join produto p on a.idp=p.id left join cat ca on p.idc=ca.id or p.idc2=ca.id left join cupom_ax u on ca.id=u.ida where a.idc='{$rc->id}' and u.idc='{$ru->id}' group by a.idp) t1")->fetchObject();
	}
	$hj = date("Y-m-d");

	//if($opcao!=1)$x->m = 'Selecione o endereço principal!';
	if(!$r->cep)$x->m = 'Digite o CEP!';
	elseif(!$__cep)$x->m = 'CEP inválido!';
	elseif(!$r->rua)$x->m = 'Digite o logradouro!';
	elseif(!$r->sem_num&&!$r->num)$x->m = 'Digite o número ou selecione!';
	elseif(!$r->bairro)$x->m = 'Digite o bairro!';
	elseif(!$r->city)$x->m = 'Digite a cidade!';
	elseif(!$r->uf)$x->m = 'Selecione o estado!';
	elseif(!$tipo)$x->m = 'Selecione o tipo de entrega!';
	elseif($pagamento=='erede'&&$cardType=='credito'&&!$cardNumber)$x->m = 'Digite o número do cartão de crédito!';
	elseif($pagamento=='erede'&&$cardType=='credito'&&$cardValidate['valid']=='invalido')$x->m = 'Cartão de crédito inválido!';
	elseif($pagamento=='erede'&&$cardType=='credito'&&!$cardName)$x->m = 'Digite o nome do cartão de crédito!';
	elseif($pagamento=='erede'&&$cardType=='credito'&&!$cardExpiry)$x->m = 'Digite a data de validade do cartão de crédito!';
	elseif($pagamento=='erede'&&$cardType=='credito'&&$cardMonth>12)$x->m = 'Mês inválido do cartão de crédito!';
	elseif($pagamento=='erede'&&$cardType=='credito'&&!$cardCVC)$x->m = 'Digite o código de segurança do cartão de crédito!';
	elseif($pagamento=='erede'&&$cardType=='credito'&&(!$cardInstallments||$cardInstallments>3))$x->m = 'Quantidade de parcelas inválida!';
	elseif($pagamento=='erede'&&$cardType=='debito'&&!$debitNumber)$x->m = 'Digite o número do cartão de débito!';
	elseif($pagamento=='erede'&&$cardType=='debito'&&!$debitName)$x->m = 'Digite o nome do cartão de débito!';
	elseif($pagamento=='erede'&&$cardType=='debito'&&!$debitExpiry)$x->m = 'Digite a data de validade do cartão de débito!';
	elseif($pagamento=='erede'&&$cardType=='debito'&&$debitMonth>12)$x->m = 'Mês inválido do cartão de débito!';
	elseif($pagamento=='erede'&&$cardType=='debito'&&!$debitCVV)$x->m = 'Digite o código de segurança do cartão de débito!';
	elseif($se->rowCount())$x->m = 'Algum produto não encontra-se em estoque ou a quantidade em estoque é menor!';
	elseif($rc->idd&&$rc->v<$ru->v)$x->m = "Para usar este cupom!\nO valor do pedido precisa de ser ao menos R$ {$ru->v}!";
	elseif($rc->idd&&$ru->dv<$hj)$x->m = "O cupom expirou, atingiu seu limite de uso!\nRemova o Cupom!";
	elseif($rc->idd&&$ru->q<=$ru->u)$x->m = 'O cupom atingiu seu limite de uso!';
	elseif($rc->idd&&$rm->q>$ru->l)$x->m = 'Você já utilizou este cupom!';
	elseif($rc->idd&&!$cupom->t=='NULL')$x->m = 'Os produtos que estão no carrinho não fazem parte deste cupom de desconto!';
	else{
		$url = "{$_SERVER['HTTP_HOST']}{$s->dir}";
		$s->end = $_SESSION['end'] = '';
		$x->end = $s->end = $_SESSION['end'] = $r;
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


			$rc->vd = $rc->vd?$rc->vd:0;//DESCONTO
			$x->total = $rc->t - $rc->vd + $x->frete->val;//TOTAL SEM IMPOSTO
			$total = $x->total;
			if($s->idc==1)$total = 1;
			$desconto_cupom = $descontos = $rc->vd;
			if($pagamento=='erede'&&$s->idc==1)$x->imp = $x->imposto = 2.95;
			else $x->imp = $x->imposto = 0;
			$x->total = $total+$x->imposto;

//INÍCIO EREDE
			require_once "class/erede/Classloader.php";
			//$pv = '10000435';//SANDBOX
			//$token = 'b74b1b812e7141cb98b11e60764caaa8';//SANDBOX
			$pv = '75867664';
			$token = '354220e0e6ca4277822db0592f2a8505';

			try{
				$id_cupom = $rc->idd;
				$cod_cupom = $ru->c;
				//$cardNumber = '5448280000000007';//CARTÃO DE TESTE
				//$cardMonth = '01';//CARTÃO DE TESTE
				//$cardYear = '19';//CARTÃO DE TESTE
				//$cardCVC = '123';//CARTÃO DE TESTE
				$totalErede = str_replace(array('.', ','),"",nreal($x->total));
				$x->totalErede = $totalErede;

				$request = new TransactionRequest();
				$request->setCapture("true");
				if($cardType=='credito'){
					$request->setKind(TransactionKind::CREDIT);
					if($cardInstallments>=2)$request->setInstallments($cardInstallments);
					else $request->setInstallments(1);
					$request->setCardHolderName($cardName);
					$request->setCardNumber($cardNumber);
					$request->setExpirationMonth($cardMonth);
					$request->setExpirationYear($cardYear);
					$request->setSecurityCode($cardCVC);
				}
				if($cardType=='debito'){
					$request->setKind(TransactionKind::DEBIT);
					$request->setCardHolderName($debitName);
					$request->setCardNumber($debitNumber);
					$request->setExpirationMonth($debitMonth);
					$request->setExpirationYear($debitYear);
					$request->setSecurityCode($debitCVV);
				}
				$request->setReference(mt_rand(0, 99999999));
				$request->setAmount($totalErede);
				//$request->setSoftDescriptor('Loja');
				$request->setSubscription('false');
				$request->setOrigin('01');
				$request->setDistributorAffiliation($pv);

				$last = $b->query("select AUTO_INCREMENT as id from INFORMATION_SCHEMA.TABLES  WHERE TABLE_NAME = 'pedido'")->fetchObject();
				$urls = array();
				$urlCallback = new UrlRequest();
				$urlCallback->setKind(UrlKind::CALLBACK);
				$urlCallback->setUrl("{$s->dom}{$s->dir}notification/{$last->id}");
				$urls[] = $urlCallback;
				$request->setUrls($urls);
				/*$urls = array();
				$urls[] = $redirect;
				$urls[] = $cancel;
				$urls[] = $notification;
				$urls[] = $orderNotification;*/

				$acquirer = new Acquirer($pv,$token,EnvironmentType::PRODUCTION);
				//$acquirer = new Acquirer($pv,$token,EnvironmentType::HOMOLOG);
				$x->RequestJSON = $request->toJson();
				$response = $acquirer->authorize($request);
				$x->ResponseJSON  = $response->toJson();
				$x->tid = $tid = $response->getTid();
				$x->nsu = $nsu = $response->getNsu();
				$x->reference = $reference = $response->getReference();
				$x->authorizationCode = $authorizationCode = $response->getAuthorizationCode();
				$x->cardBin = $cardBin = $response->getCardBin();
				$x->last4 = $last4 = $response->getLast4();
				$x->parcelas = $parcelas = $response->getInstallments();

				$idc = $rc->id;
				$b->exec("update cart set s=2,da=now() where id=$idc limit 1");
				$cart_ax = $b->query("select count(*) as qp,sum(q) as qtd from cart_ax where idc=$idc")->fetchObject();
				if($tid){
					$b->exec("insert into pedido set forma='$pagamento',tipoCartao='$cardType',dc=now(),idu={$s->idc},idd='$id_cupom',cod_cupom='$cod_cupom',tf=$tipo,i='{$cart_ax->qp}',q='{$cart_ax->qtd}',v='{$rc->t}',f='{$x->frete->val}',t='$total',vd='$descontos',desconto_cupom='$desconto_cupom',n='$address_nome',rua='$address_rua',num='$address_num',comp='$address_comp',bairro='$address_bairro',cep='$address_cep',city='$address_city',uf='$address_uf',t1='{$x->t1}',idc=$idc,w='{$rc->w}',parcelas='$parcelas',tid='$tid',nsu='$nsu',reference='$reference',authorizationCode='$authorizationCode',cardBin='$cardBin',last4='$last4'");
					$id = $b->lastInsertId();
					$img = "{$s->base}upload/produtos/thumb/";
					$sa = $b->query("select a.*,p.id idp,f.itc,p.h1,p.t tag,(p.estoque - a.q) as estoque from cart_ax a left join produto p on a.idp=p.id left join fotos f on p.id=f.idp and tipo='produto' and f.principal where a.idc=$idc");
					while($ra=$sa->fetchObject()){
						$w = $ra->q * $ra->p;
						$totals = $ra->v * $ra->q;
						$estoque = (int)$ra->estoque;
						$b->query("update produto set estoque=$estoque where id='{$ra->idp}'");
						$b->exec("insert into pedido_ax set idc=$id,idp='{$ra->idp}',q='{$ra->q}',v='{$ra->v}',t='{$ra->t}',p='{$ra->p}',w='$w'");
						$link = "{$s->base}produto/".$ra->idp."/".$ra->tag;
						$produtosEmail.= '<tr class="produtos-email">
							<td width="65" valign="middle" align="center" style="background:#fff">
								<a href="'.$link.'"><img src="'.$img.$ra->itc.'" alt="'.$ra->h1.'" data-default="placeholder" width="60" height="72"></a>
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
					if($rc->idd)$b->query("update cupom set u=u+1 where id='{$rc->idd}' limit 1");
					$x->retorno = $response;

					$x->total = nreal($x->total);
					$x->freteVal = nreal($x->frete->val);
					$x->imposto = nreal($x->imposto);
					$x->tf = $tipo;
					$x->forma_envio = $tipo==1?'PAC':($tipo==2?'SEDEX':($tipo==3?'ESEDEX':''));
					$s->envio = $_SESSION['envio'] = $tipo;
					$s->pagamento = $_SESSION['pagamento'] = $pagamento;
					$x->ok = 1;
					if($s->idc!=1)$x->l = 'obrigado/'.$id;
				}else{
					$x->ok = 0;
					$x->m = $response->getReturnMessage();
				}
			}catch(Exception $e){
				$x->m = $e->getMessage();
				die($e->getMessage());
			}
//FIM EREDE
		}else{
			$x->m = $x->frete->m;
			$x->noopcoes = '<strong style="color:#7b0310">No momento não temos nenhuma opção de envio disponível.<br>Tente novamente em alguns instantes!</strong>';
		}
	}
}else $neg = true;
?>