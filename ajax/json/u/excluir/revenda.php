<?
if(true){
	$id = strp('id',3);

	$P = 'upload/revendas/';
	$R = strp('ri',3)?1:0;
	$N = 0;
	$i = $s->getfile(strp('i',3));
	$I = 'i';
	$D = '';

	$tp = strp('tp',3);// tipo de cadastro: 1-pessoa física; 2-pessoa jurídica
	$n = strps('n');
	$t = tag($n,1);
	$email = strpr('email',1);
	$cpf = strps('cpf',1);
	$rg = strps('rg',2);
	$t1 = strps('t1');
	$t2 = strps('t2');

	$cnpj = strps('cnpj');
	$ie = strps('ie');

	$cep = strps('cep');
	$rua = strps('rua');
	$num = strps('num');
	$comp = strps('comp');
	$bairro = strps('bairro');
	$city = strps('city');
	$cityt = tag($city,1);
	$uf = strps('uf');

	$msg = strps('msg');

	if($_cpf=preg_match($cpfRE,$cpf,$_m))$cpf = "{$_m[1]}.{$_m[2]}.{$_m[3]}-{$_m[4]}";
	if($_cnpj=preg_match($cnpjRE,$cnpj,$_m))$cnpj = "{$_m[1]}.{$_m[2]}.{$_m[3]}/{$_m[4]}-{$_m[5]}";

	if($_cep=preg_match($cepRE,$cep,$_m))$cep = "{$_m[1]}-{$_m[2]}";
	if($_t1=preg_match($telRE,$t1,$_m))$t1 = "({$_m[1]}) {$_m[2]}-{$_m[3]}";
	if($_t2=preg_match($telRE,$t2,$_m))$t2 = "({$_m[1]}) {$_m[2]}-{$_m[3]}";

	if($tp!=2)$cnpj = $ie = '';

	if(!$tp||$tp>2)$x->m = 'Escolha um tipo de cadastro válido!';
	elseif(!$n)$x->m = 'Digite o nome ou razão social!';
	//elseif(strpos($n,' ')===false)$x->m = 'Digite o Nome completo!';
	elseif($tp==1&&!$cpf)$x->m = 'Digite o CPF!';
	elseif($tp==1&&(!$_cpf||!$s->validar->cpf($cpf)))$x->m = 'CPF inválido!';
	elseif($tp==1&&$b->query("select id from revenda where id!=$id and cpf='$cpf' limit 1")->fetchObject())$x->m = 'Este CPF já está cadastrado!';
	elseif($tp==1&&!$rg)$x->m = 'Digite o RG!';
	elseif($tp==2&&!$cnpj)$x->m = 'Digite o CNPJ!';
	elseif($tp==2&&(!$_cnpj||!$s->validar->cnpj($cnpj)))$x->m = 'CNPJ inválido!';
	elseif($tp==2&&$b->query("select id from revenda where id!=$id and cnpj='$cnpj' limit 1")->fetchObject())$x->m = 'Este CNPJ já está cadastrado!';
	//elseif($t==2&&!$ie)$x->m = 'Digite a Inscrição Estadual!';
	//elseif($t==2&&!$_ie)$x->m = 'Inscrição Estadual inválido!';
	elseif(!$email)$x->m = 'Digite o E-mail!';
	elseif(!preg_match($emailRE,$email))$x->m = 'E-mail inválido!';
	elseif($b->query("select id from revenda where id!=$id and email='$email' limit 1")->fetchObject())$x->m = 'Este e-mail já está cadastrado!';
	elseif(!$t1)$x->m = 'Digite o Telefone Principal!';
	elseif($t1==$t2)$x->m = 'Telefone Principal e Celular são iguais!';
	elseif(!$cep)$x->m = 'Digite o CEP!';
	elseif(!$_cep)$x->m = 'CEP inválido!';
	elseif(!$rua)$x->m = 'Digite o Logradouro!';
	//elseif(!$num)$x->m = 'Digite o Número Residencial!';
	//elseif(!$comp)$x->m = 'Digite o Complemento Residencial!';
	elseif(!$bairro)$x->m = 'Digite o Bairro!';
	elseif(!$city)$x->m = 'Digite a Cidade!';
	elseif(!$uf)$x->m = 'Selecione o Estado!';
	//elseif($msg)$x->m = 'Digite a mensagem!';
	else{
		if($b->exec("insert into revenda (dc)values(now())"))$id = $b->lastInsertId();
		if($R){
			$x->i->i = '';
			$I = 'null';
			$D = $rs->i;
		}elseif($i){
			$C = $t.'-'.date('his').'.'.$i->ex;
			if($i=$s->movefile($i->id,$P.$C)){
				$x->i->i = $P.$C;
				$I = "'$C'";
				$D = $rs->i;
				if($i->w>800&&++$N)$I = Img::resize($i->nf,$P.$C,800,0)?"'$C'":'null';
			}
		}		
		if($b->exec($x->upd="update revenda set tp=$tp,n='$n',t='$t',email='$email',cpf='$cpf',rg='$rg',t1='$t1',t2='$t2',cnpj='$cnpj',ie='$ie',cep='$cep',rua='$rua', num='$num', comp='$comp', bairro='$bairro' ,city='$city', cityt='$cityt', uf='$uf',msg='$msg',i=$I where id=$id limit 1")){
			$x->ok = 1;
			$x->m = 'Revendedor cadastrado com sucesso!';
		}else $x->m = 'Erro ao cadastrar o revendedor!';
	}
}
?>