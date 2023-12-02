<?
if(true){
	unset($r);
	$tipo = strg('tipo',3);
	if(is_array($tipo))$tipo= (int)implode('', $tipo);
	$s->idc = strg('idc',3);
	$pagamento = strgs('pagamento');
	if(is_array($pagamento))$pagamento = (int)implode('', $pagamento);
	$x->pagamento = $pagamento;
	$opcao = strg('opcao',3);
	if(is_array($opcao))$opcao = (int)implode('', $opcao);

	if($opcao==1){
		$rfrete = $b->query($tes="select n,t1,cep,rua,num,sem_num,comp,bairro,city,uf from cliente where id={$s->idc} limit 1")->fetchObject();
		$x->n = $r->n = $rfrete->n;
		$x->t1 = $r->t1 = $rfrete->t1;
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
		$address_end = strs($r->rua.','.$r->num);
		$address_bairro = strs($r->bairro);
		$address_city = strs($r->city);
		$address_cep = strs($r->cep);
		$address_uf = strs($r->uf);
		$address_t1 = strs($r->t1);
	}elseif($opcao==2){
		$rnome = $b->query("select n,t1 from cliente where id={$s->idc} limit 1")->fetchObject();
		$x->n = $r->n = $rnome->n;
		$x->t1 = $r->t1 = $rnome->t1;
		$cep = strgs('ncep');
		$rua = strgs('nrua');
		$num = strgs('nnum');
		$sem_num = strg('nsem_num',3)?1:0;
		$comp = strgs('ncomp');
		$bairro = strgs('nbairro');
		$city = strgs('ncity');
		$cityt = tag($city,1);
		$uf = strgs('nuf');
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
		$address_end = $rua.','.$num;
		$address_bairro = $bairro;
		$address_city = $city;
		$address_cep = $cep;
		$address_uf = $uf;
		$address_t1 = $t1;
	}

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
	else{
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
			elseif($tipo==5)$x->frete->val = 0;

			$rc = $b->query("select * from cart where idu='{$s->idc}' and s=1 order by id desc")->fetchObject();
			$gratis = $b->query("select frete,vf,vb,desconto,vd from dados where id=1")->fetchObject();

			$rc->vd = $rc->vd?$rc->vd:0;//DESCONTO
			$x->total = $rc->t - $rc->vd + $x->frete->val;//TOTAL SEM IMPOSTO

			$predesconto = $rc->t - $rc->vd;
			if($pagamento=='boleto'&&$gratis->desconto)$descontototal = (($predesconto*$gratis->vd)/100);
			else $descontototal = 0;

			$x->opcoes = '
				<p>Escolha o tipo de entrega</p>
				'.($x->pac?'<div class="col-sm-12">
					<p>
						<label for="pac"><img src="assets/img/frete/pac-xsmall.jpg"> PAC '.($x->valPac != '0,00' ? 'R$ '.$x->valPac : 'Grátis').' - <span>Até '.($x->frete->pacPrazo?$x->frete->pacPrazo:'9').' dias úteis</span>
							<input type="radio" id="pac" name="frete" style="height:1.3em;width:1.3em" value="1"'.($tipo==1?' checked disabled':'').'>
						</label>
					</p>
				</div>':'').'
				'.($x->sedex?'<div class="col-sm-12">
					<p>
						<label for="sedex"><img src="assets/img/frete/sedex-xsmall.jpg"> SEDEX '.($x->sedex>0?'R$ '.$x->valSedex:'GRÁTIS').' - <span>Até '.($x->frete->sedexPrazo?$x->frete->sedexPrazo:'3').' dias úteis</span>
							<input type="radio" id="sedex" name="frete" style="height:1.3em;width:1.3em" value="2"'.($tipo==2?' checked disabled':'').'>
						</label>
					</p>
				</div>':'').'
				'.($x->esedex?'<div class="col-sm-12">
					<p>
						<label for="esedex"><img src="assets/img/frete/e-sedex-xsmall.jpg"> E-SEDEX '.($x->esedex>0?'R$ '.$x->valEsedex:'GRÁTIS').' - <span>Até '.($x->frete->esedexPrazo?$x->frete->esedexPrazo:'3').' dias úteis</span>
							<input type="radio" id="esedex" name="frete" style="height:1.3em;width:1.3em" value="3"'.($tipo==3?' checked disabled':'').'>
						</label>
					</p>
				</div>':'').'
				'.($gratis->frete&&$rc->t>=$gratis->vf?'<div class="col-sm-12">
					<p>
						<label for="gratis">FRETE GRÁTIS - <span>Até 11 dias úteis</span>
							<input type="radio" id="gratis" name="frete" value="5"'.($tipo==5?' checked disabled':'').'>
						</label>
					</p>
				</div>':'');

			$total = $x->total;
			if($pagamento=='erede'&&$s->idc==1)$x->imp = $x->imposto = 2.95;
			else $x->imp = $x->imposto = 0;
			//if($pagamento=='boleto')$total = $total + $gratis->vb;
			if($pagamento=='erede')$total = $x->total;
			if($pagamento=='boleto')$total = $x->total - $descontototal + $gratis->vb;
			if(!$pagamento)$total = $x->total;
			$x->total = $total+$x->imposto;


			$x->totalOri = $rc->t;
			$x->freteOri = $x->frete->val;
			$x->desconto = $rc->vd;
			$x->total = nreal($x->total);
			$x->freteVal = nreal($x->frete->val);
			$x->imposto = nreal($x->imposto);
			$x->descontototal = nreal($descontototal);
			$x->tf = $tipo;
			$x->forma_envio = $tipo==1?'pac':($tipo==2?'sedex':($tipo==3?'E-sedex':''));
			$x->envio = $s->envio = $_SESSION['envio'] = $tipo;
			$s->pagamento = $_SESSION['pagamento'] = $pagamento;
			$x->tarifa = $gratis->vb;
			$x->ok = 1;
		}else{
			$x->m = $x->frete->m;
			$x->noopcoes = '<strong style="color:#7b0310">No momento não temos nenhuma opção de envio disponível.<br>Tente novamente em alguns instantes!</strong>';
		}
	}
}else $neg = true;
?>