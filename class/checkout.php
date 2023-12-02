<?php
class checkout{
	public function getAddress($opcao,$id_cliente){
		global $b;
		global $telRE;
		global $cpfRE;
		global $cnpjRE;
		if($opcao==1){
			$rfrete = $b->query("select tp,n,r,t1,email,cpf,cnpj,cep,rua,num,sem_num,comp,bairro,city,uf,dn from cliente where id=$id_cliente limit 1")->fetchObject();
			$x->tp = $rfrete->tp;
			$x->n = $r->n = $rfrete->tp==1?$rfrete->n:$rfrete->r;
			$x->t1 = $r->t1 = $rfrete->t1;
			if($_t1=preg_match($telRE,$x->t1,$_m)){
				$x->t1 = $r->t1 = $t1 = "{$_m[2]}{$_m[3]}";
				$x->ddd = $r->ddd = $ddd = "{$_m[1]}";
			}
			if($_cpf=preg_match($cpfRE,$rfrete->cpf,$_m))$cpf = "{$_m[1]}{$_m[2]}{$_m[3]}{$_m[4]}";
			if($_cnpj=preg_match($cnpjRE,$rfrete->cnpj,$_m))$cnpj = "{$_m[1]}.{$_m[2]}.{$_m[3]}/{$_m[4]}-{$_m[5]}";
			$cpf_cnpj = $rfrete->tp==1?$cpf:$cnpj;
			$tipo_cpf_cnpj = $rfrete->tp==1?'cpf':'cnpj';
			$nome_razao = $rfrete->tp=='1'?'Nome':'Razão Social';
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
			$x->dn = $r->dn = $rfrete->dn;	
			$address->nome = strs($r->n);
			$address->email = strs($r->email);
			$address->rua = strs($r->rua);
			$address->num = strs($r->num);
			$address->bairro = strs($r->bairro);
			$address->city = strs($r->city);
			$address->cep = strs($r->cep);
			$address->uf = strs($r->uf);
			$address->comp = strs($r->comp);
			$address->ddd = strs($r->ddd);
			$address->t1 = strs($r->t1);
			$address->t1 = str_replace('_','',$address->t1);
			$address->tel = strs($rfrete->t1);
			$address->tel = str_replace('_','',$address->tel);
			$address->nome_razao = strs($nome_razao);
			$address->tipo_cpf_cnpj = strs($tipo_cpf_cnpj);
			$address->cpf_cnpj = $cpf_cnpj;
			$address->dn = strs($r->dn);
		}elseif($opcao==2){
			$rfrete = $b->query("select tp,n,r,t1,email,cpf,cnpj,dn from cliente where id=$id_cliente limit 1")->fetchObject();
			$x->tp = $rfrete->tp;
			$x->n = $r->n = $rfrete->tp==1?$rfrete->n:$rfrete->r;
			$x->t1 = $r->t1 = $rfrete->t1;
			if($_t1=preg_match($telRE,$x->t1,$_m)){
				$x->t1 = $r->t1 = $t1 = "{$_m[2]}{$_m[3]}";
				$x->ddd = $r->ddd = $ddd = "{$_m[1]}";
			}
			if($_cpf=preg_match($cpfRE,$rfrete->cpf,$_m))$cpf = "{$_m[1]}{$_m[2]}{$_m[3]}{$_m[4]}";
			if($_cnpj=preg_match($cnpjRE,$rfrete->cnpj,$_m))$cnpj = "{$_m[1]}.{$_m[2]}.{$_m[3]}/{$_m[4]}-{$_m[5]}";
			$cpf_cnpj = $rfrete->tp==1?$cpf:$cnpj;
			$tipo_cpf_cnpj = $rfrete->tp==1?'CPF':'CNPJ';
			$nome_razao = $rfrete->tp=='1'?'Nome':'Razão Social';
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
			$x->dn = $r->dn = $rfrete->dn;	
			$address->nome = strs($r->n);
			$address->email = strs($r->email);
			$address->rua = strs($r->rua);
			$address->num = strs($r->num);
			$address->bairro = strs($r->bairro);
			$address->city = strs($r->city);
			$address->cep = strs($r->cep);
			$address->uf = strs($r->uf);
			$address->comp = strs($r->comp);
			$address->ddd = strs($r->ddd);
			$address->t1 = strs($r->t1);
			$address->t1 = str_replace('_','',$address->t1);
			$address->tel = strs($rfrete->t1);
			$address->tel = str_replace('_','',$address->tel);
			$address->nome_razao = strs($nome_razao);
			$address->tipo_cpf_cnpj = strs($tipo_cpf_cnpj);
			$address->cpf_cnpj = $cpf_cnpj;
			$address->dn = strs($r->dn);
		}
		return $address;
	}
	public function setProduto($id_pedido,$img,$id_cart){
		global $b;
		global $s;
		$sa = $b->query("select a.*,p.id idp,f.itc,p.h1,p.t tag,(p.estoque - a.q) as estoque from cart_ax a left join produto p on a.idp=p.id left join fotos f on p.id=f.idp and tipo='produto' and f.principal where a.idc=$id_cart");
		while($ra=$sa->fetchObject()){
			$w = $ra->q * $ra->p;
			$totals = $ra->v * $ra->q;
			$estoque = (int)$ra->estoque;
			$b->query("update produto set estoque=$estoque where id='{$ra->idp}'");
			$b->exec("insert into pedido_ax set idc=$id_pedido,idp='{$ra->idp}',q='{$ra->q}',v='{$ra->v}',t='{$ra->t}',p='{$ra->p}',w='$w'");
			$link = "{$s->base}".$ra->tag;
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
		}//PESQUISAR COMO COLOCAR HTML EOL
		return $produtosEmail;
	}
}