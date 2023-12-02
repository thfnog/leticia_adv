<?php
if(true){
	$id = strp('id',3);
	$S = strp('s',3)?1:0;
	$S = 1;

	$u = strps('u');
	$senha = strps('p',1);
	$p2 = strps('p2',1);

	$tp = strp('tp',3); // tipo de cadastro: 1-pessoa física; 2-pessoa jurídica
	$n = strps('n');
	$t = tag($n,1);
	$nc = strps('nc');
	$tc = tag($nc,1);
	$email = strpr('email',1);
	$sx = strp('sx',3); // sexo: 1-masculino; 2-feminino
	$dn = strps('dn');
	$cpf = strps('cpf',1);
	$rg = strps('rg',2);
	$t1 = strps('t1');
	$t2 = strps('t2');
	$t3 = strps('t3');

	$r = strps('r');
	$nf = strps('nf');
	$cnpj = strps('cnpj');
	$ie = strps('ie');
	$im = strps('im');

	$cep = strps('cep');
	$rua = strps('rua');
	$num = strps('num');
	$sem_num = strp('sem_num',3)?1:0;
	$comp = strps('comp');
	$bairro = strps('bairro');
	$city = strps('city');
	$cityt = tag($city,1);
	$uf = strps('uf');

	$pg = strps('pg');
	$termos = strp('termos',3)?1:0;

	/*if($pg!='checkout'){
		$recaptchaResponse = strpr('g-recaptcha-response');
		$secretKey = '6LeDYk4UAAAAAFzqnvPMuiG2AqvU5nFJDTU3PTTc';
		if($recaptchaResponse){
			$url = "https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$recaptchaResponse;
			$request = json_decode(file_get_contents($url));
		}
	}*/

	$hj = date('Y-m-d');
	$anoMinimo = date('1900-01-01');
	if($_dn=preg_match($dataRE,$dn,$_m))$dn = "{$_m[3]}-{$_m[2]}-{$_m[1]}";
	if($_cpf=preg_match($cpfRE,$cpf,$_m))$cpf = "{$_m[1]}.{$_m[2]}.{$_m[3]}-{$_m[4]}";
	if($_cnpj=preg_match($cnpjRE,$cnpj,$_m))$cnpj = "{$_m[1]}.{$_m[2]}.{$_m[3]}/{$_m[4]}-{$_m[5]}";
	if($_ie=preg_match($ieRE,$ie,$_m))$ie = "{$_m[1]}.{$_m[2]}.{$_m[3]}.{$_m[4]}";

	if($_tt1=preg_match($telRE,$tt1,$_m))$tt1 = "({$_m[1]}) {$_m[2]}-{$_m[3]}";
	if($_tt2=preg_match($telRE,$tt2,$_m))$tt2 = "({$_m[1]}) {$_m[2]}-{$_m[3]}";

	if($_cep=preg_match($cepRE,$cep,$_m))$cep = "{$_m[1]}-{$_m[2]}";
	if($_t1=preg_match($telRE,$t1,$_m))$t1 = "({$_m[1]}) {$_m[2]}-{$_m[3]}";
	if($_t2=preg_match($telRE,$t2,$_m))$t2 = "({$_m[1]}) {$_m[2]}-{$_m[3]}";
	$t1 = str_replace('_','',$t1);
	$t2 = str_replace('_','',$t2);
	/*if($_t1=preg_match($telRE,$t1,$_m)){
		$t1 = "{$_m[2]}-{$_m[3]}";
		$ddd1 = "{$_m[1]}";
	}if($_t2=preg_match($telRE,$t2,$_m)){
		$t2 = "{$_m[2]}-{$_m[3]}";
		$ddd2 = "{$_m[1]}";
	}if($_t3=preg_match($telRE,$t3,$_m)){
		$t3 = "{$_m[2]}-{$_m[3]}";
		$ddd3 = "{$_m[1]}";
	}*///SEPARANDO DDD

	if($_ccep=preg_match($cepRE,$ccep,$_m))$ccep = "{$_m[1]}-{$_m[2]}";

	//if($_ie=preg_match($ieRE,$ie,$_m))$ie = "{$_m[1]}.{$_m[2]}.{$_m[3]}.{$_m[4]}";

	if($tp!=2)$r = $nf = $cnpj = $ie = $im = '';
	//if(!$t)$tn = $tc = $ts = $tt1 = $tt2 = '';

	$rs = $b->query("select * from cliente where id=$id limit 1")->fetchObject();
	$x->e = array();
//$request->success
	if($id&&!$b->query("select id from cliente where id=$id limit 1")->fetchObject())$x->m = 'Este cliente não existe!';
	//elseif(!$u)$x->m = 'Digite o usuário!';
	//elseif($b->query("select id from cliente where id!=$id and u='$u' limit 1")->fetchObject())$x->m = 'Este nome de usuário está indisponível!';
	elseif(!$email){
		$x->e['email'] = $x->m = 'Digite o E-mail!';
		$x->f = 'email';
		if($pg!='checkout')$x->resetCaptcha = 0;//TIRAR COMENTÁRIO DEPOIS
	}elseif(!preg_match($emailRE,$email)){
		$x->e['email'] = $x->m = 'E-mail inválido!';
		$x->f = 'email';
		if($pg!='checkout')$x->resetCaptcha = 0;//TIRAR COMENTÁRIO DEPOIS
	}elseif($b->query("select id from cliente where id!=$id and email='$email' limit 1")->fetchObject()){
		$x->e['email'] = $x->m = 'Este e-mail não está disponível!';
		$x->f = 'email';
		if($pg!='checkout')$x->resetCaptcha = 0;//TIRAR COMENTÁRIO DEPOIS
	}elseif(!$id&&!$senha){
		$x->e['p'] = $x->m = 'Digite a senha!';
		$x->f = 'p';
		if($pg!='checkout')$x->resetCaptcha = 0;//TIRAR COMENTÁRIO DEPOIS
		if(!$id&&!$p2)$x->e['p2'] = 'Digite a confirmação de senha!';
		if(!$id&&$senha!=$p2)$x->e['p2'] = 'A senha e a confirmação de senha estão diferentes!';
		if(!$tp||$tp!=1&&$tp!=2)$x->e['tp'] = 'Selecione o tipo de cadastro!';
		if($tp==2&&!$nc)$x->e['nc'] = 'Digite o nome!';
		if($tp==2&&strpos($nc,' ')===false)$x->e['nc'] = 'Digite o nome completo!';
		if($tp==2&&!$r)$x->e['r'] = 'Digite a razão social!';
		if($tp==2&&!$cnpj)$x->e['cnpj'] = 'Digite o CNPJ!';
		if($tp==2&&(!$_cnpj||!$s->validar->cnpj($cnpj)))$x->e['cnpj'] = 'CNPJ inválido';
		if($tp==2&&$b->query("select id from cliente where id!=$id and cnpj='$cnpj' limit 1")->fetchObject())$x->e['cnpj'] = 'Este CNPJ já está cadastrado!';
		if($tp==2&&$isento_insc=='NULL'&&!$ie)$x->e['ie'] = 'Digite a inscrição estadual!';
		if($tp==1&&!$n)$x->e['n'] = 'Digite o nome!';
		if($tp==1&&strpos($n,' ')===false)$x->e['n'] = 'Digite o nome completo!';
		if($tp==1&&!$cpf)$x->e['cpf'] = 'Digite o CPF!';
		if($tp==1&&(!$_cpf||!$s->validar->cpf($cpf)))$x->e['cpf'] = 'CPF inválido!';
		if($tp==1&&$b->query("select id from cliente where id!=$id and cpf='$cpf' limit 1")->fetchObject())$x->e['cpf'] = 'Este CPF já está cadastrado!';
		//if($tp==1&&!$rg)$x->e['rg'] = 'Digite o RG!';
		if($tp==1&&!$dn)$x->e['dn'] = 'Digite a data de nascimento!';
		if($tp==1&&!$_dn||($tp==1&&$dn>$hj)||($tp==1&&$dn<$anoMinimo))$x->e['dn'] = 'Data de Nascimento inválida!';
		if(!$t1)$x->e['t1'] = 'Digite o telefone principal!';
		if(!validaFone($t1))$x->e['t1'] = 'Telefone principal inválido!';
		if($t2&&$t2&&$t1==$t2)$x->e['t2'] = 'Telefone principal e telefone 2 são iguais!';
		if($t3&&$t1==$t3)$x->e['t3'] = 'Telefone principal e telefone 3 são iguais!';
		if($t2&&$t2==$t3)$x->e['t3'] = 'Telefone 2 e telefone 3 são iguais!';
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
		if(!$termos)$x->e['termos'] = 'Você precisa concordar com as Politicas o Site!';
	}elseif(!$tp||$tp!=1&&$tp!=2){
		$x->e['tp'] = $x->m = 'Selecione o tipo de cadastro!';
		$x->f = 'tp';
		if($pg!='checkout')$x->resetCaptcha = 0;//TIRAR COMENTÁRIO DEPOIS
		if($tp==2&&!$nc)$x->e['nc'] = 'Digite o nome!';
		if($tp==2&&strpos($nc,' ')===false)$x->e['nc'] = 'Digite o nome completo!';
		if($tp==2&&!$r)$x->e['r'] = 'Digite a razão social!';
		if($tp==2&&!$cnpj)$x->e['cnpj'] = 'Digite o CNPJ!';
		if($tp==2&&(!$_cnpj||!$s->validar->cnpj($cnpj)))$x->e['cnpj'] = 'CNPJ inválido';
		if($tp==2&&$b->query("select id from cliente where id!=$id and cnpj='$cnpj' limit 1")->fetchObject())$x->e['cnpj'] = 'Este CNPJ já está cadastrado!';
		if($tp==2&&$isento_insc=='NULL'&&!$ie)$x->e['ie'] = 'Digite a inscrição estadual!';
		if($tp==1&&!$n)$x->e['n'] = 'Digite o nome!';
		if($tp==1&&strpos($n,' ')===false)$x->e['n'] = 'Digite o nome completo!';
		if($tp==1&&!$cpf)$x->e['cpf'] = 'Digite o CPF!';
		if($tp==1&&(!$_cpf||!$s->validar->cpf($cpf)))$x->e['cpf'] = 'CPF inválido!';
		if($tp==1&&$b->query("select id from cliente where id!=$id and cpf='$cpf' limit 1")->fetchObject())$x->e['cpf'] = 'Este CPF já está cadastrado!';
		//if($tp==1&&!$rg)$x->e['rg'] = 'Digite o RG!';
		if($tp==1&&!$dn)$x->e['dn'] = 'Digite a data de nascimento!';
		if($tp==1&&!$_dn||($tp==1&&$dn>$hj)||($tp==1&&$dn<$anoMinimo))$x->e['dn'] = 'Data de Nascimento inválida!';
		if(!$t1)$x->e['t1'] = 'Digite o telefone principal!';
		if(!validaFone($t1))$x->e['t1'] = 'Telefone principal inválido!';
		if($t2&&$t1==$t2)$x->e['t2'] = 'Telefone principal e telefone 2 são iguais!';
		if($t3&&$t1==$t3)$x->e['t3'] = 'Telefone principal e telefone 3 são iguais!';
		if($t2&&$t2==$t3)$x->e['t3'] = 'Telefone 2 e telefone 3 são iguais!';
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
		if(!$termos)$x->e['termos'] = 'Você precisa concordar com as Politicas o Site!';
	}elseif($tp==2&&!$nc){
		$x->e['nc'] = $x->m = 'Digite o nome!';
		$x->f = 'nc';
		if($pg!='checkout')$x->resetCaptcha = 0;//TIRAR COMENTÁRIO DEPOIS
		if($tp==2&&strpos($nc,' ')===false)$x->e['nc'] = 'Digite o nome completo!';
		if($tp==2&&!$r)$x->e['r'] = 'Digite a razão social!';
		if($tp==2&&!$cnpj)$x->e['cnpj'] = 'Digite o CNPJ!';
		if($tp==2&&(!$_cnpj||!$s->validar->cnpj($cnpj)))$x->e['cnpj'] = 'CNPJ inválido';
		if($tp==2&&$b->query("select id from cliente where id!=$id and cnpj='$cnpj' limit 1")->fetchObject())$x->e['cnpj'] = 'Este CNPJ já está cadastrado!';
		if($tp==2&&$isento_insc=='NULL'&&!$ie)$x->e['ie'] = 'Digite a inscrição estadual!';
		if($tp==1&&!$n)$x->e['n'] = 'Digite o nome!';
		if($tp==1&&strpos($n,' ')===false)$x->e['n'] = 'Digite o nome completo!';
		if($tp==1&&!$cpf)$x->e['cpf'] = 'Digite o CPF!';
		if($tp==1&&(!$_cpf||!$s->validar->cpf($cpf)))$x->e['cpf'] = 'CPF inválido!';
		if($tp==1&&$b->query("select id from cliente where id!=$id and cpf='$cpf' limit 1")->fetchObject())$x->e['cpf'] = 'Este CPF já está cadastrado!';
		//if($tp==1&&!$rg)$x->e['rg'] = 'Digite o RG!';
		if($tp==1&&!$dn)$x->e['dn'] = 'Digite a data de nascimento!';
		if($tp==1&&!$_dn||($tp==1&&$dn>$hj)||($tp==1&&$dn<$anoMinimo))$x->e['dn'] = 'Data de Nascimento inválida!';
		if(!$t1)$x->e['t1'] = 'Digite o telefone principal!';
		if(!validaFone($t1))$x->e['t1'] = 'Telefone principal inválido!';
		if($t2&&$t1==$t2)$x->e['t2'] = 'Telefone principal e telefone 2 são iguais!';
		if($t3&&$t1==$t3)$x->e['t3'] = 'Telefone principal e telefone 3 são iguais!';
		if($t2&&$t2==$t3)$x->e['t3'] = 'Telefone 2 e telefone 3 são iguais!';
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
		if(!$termos)$x->e['termos'] = 'Você precisa concordar com as Politicas o Site!';
	}elseif($tp==2&&strpos($nc,' ')===false){
		$x->e['nc'] = $x->m = 'Digite o nome completo!';
		$x->f = 'nc';
		if($pg!='checkout')$x->resetCaptcha = 0;//TIRAR COMENTÁRIO DEPOIS
		if($tp==2&&!$r)$x->e['r'] = 'Digite a razão social!';
		if($tp==2&&!$cnpj)$x->e['cnpj'] = 'Digite o CNPJ!';
		if($tp==2&&(!$_cnpj||!$s->validar->cnpj($cnpj)))$x->e['cnpj'] = 'CNPJ inválido';
		if($tp==2&&$b->query("select id from cliente where id!=$id and cnpj='$cnpj' limit 1")->fetchObject())$x->e['cnpj'] = 'Este CNPJ já está cadastrado!';
		if($tp==2&&$isento_insc=='NULL'&&!$ie)$x->e['ie'] = 'Digite a inscrição estadual!';
		if($tp==1&&!$n)$x->e['n'] = 'Digite o nome!';
		if($tp==1&&strpos($n,' ')===false)$x->e['n'] = 'Digite o nome completo!';
		if($tp==1&&!$cpf)$x->e['cpf'] = 'Digite o CPF!';
		if($tp==1&&(!$_cpf||!$s->validar->cpf($cpf)))$x->e['cpf'] = 'CPF inválido!';
		if($tp==1&&$b->query("select id from cliente where id!=$id and cpf='$cpf' limit 1")->fetchObject())$x->e['cpf'] = 'Este CPF já está cadastrado!';
		//if($tp==1&&!$rg)$x->e['rg'] = 'Digite o RG!';
		if($tp==1&&!$dn)$x->e['dn'] = 'Digite a data de nascimento!';
		if($tp==1&&!$_dn||($tp==1&&$dn>$hj)||($tp==1&&$dn<$anoMinimo))$x->e['dn'] = 'Data de Nascimento inválida!';
		if(!$t1)$x->e['t1'] = 'Digite o telefone principal!';
		if(!validaFone($t1))$x->e['t1'] = 'Telefone principal inválido!';
		if($t2&&$t1==$t2)$x->e['t2'] = 'Telefone principal e telefone 2 são iguais!';
		if($t3&&$t1==$t3)$x->e['t3'] = 'Telefone principal e telefone 3 são iguais!';
		if($t2&&$t2==$t3)$x->e['t3'] = 'Telefone 2 e telefone 3 são iguais!';
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
		if(!$termos)$x->e['termos'] = 'Você precisa concordar com as Politicas o Site!';
	}elseif($tp==2&&!$r){
		$x->e['r'] = $x->m = 'Digite a razão social!';
		$x->f = 'r';
		if($pg!='checkout')$x->resetCaptcha = 0;//TIRAR COMENTÁRIO DEPOIS
		if($tp==2&&!$cnpj)$x->e['cnpj'] = 'Digite o CNPJ!';
		if($tp==2&&(!$_cnpj||!$s->validar->cnpj($cnpj)))$x->e['cnpj'] = 'CNPJ inválido';
		if($tp==2&&$b->query("select id from cliente where id!=$id and cnpj='$cnpj' limit 1")->fetchObject())$x->e['cnpj'] = 'Este CNPJ já está cadastrado!';
		if($tp==2&&$isento_insc=='NULL'&&!$ie)$x->e['ie'] = 'Digite a inscrição estadual!';
		if($tp==1&&!$n)$x->e['n'] = 'Digite o nome!';
		if($tp==1&&strpos($n,' ')===false)$x->e['n'] = 'Digite o nome completo!';
		if($tp==1&&!$cpf)$x->e['cpf'] = 'Digite o CPF!';
		if($tp==1&&(!$_cpf||!$s->validar->cpf($cpf)))$x->e['cpf'] = 'CPF inválido!';
		if($tp==1&&$b->query("select id from cliente where id!=$id and cpf='$cpf' limit 1")->fetchObject())$x->e['cpf'] = 'Este CPF já está cadastrado!';
		//if($tp==1&&!$rg)$x->e['rg'] = 'Digite o RG!';
		if($tp==1&&!$dn)$x->e['dn'] = 'Digite a data de nascimento!';
		if($tp==1&&!$_dn||($tp==1&&$dn>$hj)||($tp==1&&$dn<$anoMinimo))$x->e['dn'] = 'Data de Nascimento inválida!';
		if(!$t1)$x->e['t1'] = 'Digite o telefone principal!';
		if(!validaFone($t1))$x->e['t1'] = 'Telefone principal inválido!';
		if($t2&&$t1==$t2)$x->e['t2'] = 'Telefone principal e telefone 2 são iguais!';
		if($t3&&$t1==$t3)$x->e['t3'] = 'Telefone principal e telefone 3 são iguais!';
		if($t2&&$t2==$t3)$x->e['t3'] = 'Telefone 2 e telefone 3 são iguais!';
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
		if(!$termos)$x->e['termos'] = 'Você precisa concordar com as Politicas o Site!';
	}elseif($tp==2&&!$cnpj){
		$x->e['cnpj'] = $x->m = 'Digite o CNPJ!';
		$x->f = 'cnpj';
		if($pg!='checkout')$x->resetCaptcha = 0;//TIRAR COMENTÁRIO DEPOIS
		if($tp==2&&(!$_cnpj||!$s->validar->cnpj($cnpj)))$x->e['cnpj'] = 'CNPJ inválido';
		if($tp==2&&$b->query("select id from cliente where id!=$id and cnpj='$cnpj' limit 1")->fetchObject())$x->e['cnpj'] = 'Este CNPJ já está cadastrado!';
		if($tp==2&&$isento_insc=='NULL'&&!$ie)$x->e['ie'] = 'Digite a inscrição estadual!';
		if($tp==1&&!$n)$x->e['n'] = 'Digite o nome!';
		if($tp==1&&strpos($n,' ')===false)$x->e['n'] = 'Digite o nome completo!';
		if($tp==1&&!$cpf)$x->e['cpf'] = 'Digite o CPF!';
		if($tp==1&&(!$_cpf||!$s->validar->cpf($cpf)))$x->e['cpf'] = 'CPF inválido!';
		if($tp==1&&$b->query("select id from cliente where id!=$id and cpf='$cpf' limit 1")->fetchObject())$x->e['cpf'] = 'Este CPF já está cadastrado!';
		//if($tp==1&&!$rg)$x->e['rg'] = 'Digite o RG!';
		if($tp==1&&!$dn)$x->e['dn'] = 'Digite a data de nascimento!';
		if($tp==1&&!$_dn||($tp==1&&$dn>$hj)||($tp==1&&$dn<$anoMinimo))$x->e['dn'] = 'Data de Nascimento inválida!';
		if(!$t1)$x->e['t1'] = 'Digite o telefone principal!';
		if(!validaFone($t1))$x->e['t1'] = 'Telefone principal inválido!';
		if($t2&&$t1==$t2)$x->e['t2'] = 'Telefone principal e telefone 2 são iguais!';
		if($t3&&$t1==$t3)$x->e['t3'] = 'Telefone principal e telefone 3 são iguais!';
		if($t2&&$t2==$t3)$x->e['t3'] = 'Telefone 2 e telefone 3 são iguais!';
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
		if(!$termos)$x->e['termos'] = 'Você precisa concordar com as Politicas o Site!';
	}elseif($tp==2&&(!$_cnpj||!$s->validar->cnpj($cnpj))){
		$x->e['cnpj'] = $x->m = 'CNPJ inválido!';
		$x->f = 'cnpj';
		if($pg!='checkout')$x->resetCaptcha = 0;//TIRAR COMENTÁRIO DEPOIS
		if($tp==2&&$b->query("select id from cliente where id!=$id and cnpj='$cnpj' limit 1")->fetchObject())$x->e['cnpj'] = 'Este CNPJ já está cadastrado!';
		if($tp==2&&$isento_insc=='NULL'&&!$ie)$x->e['ie'] = 'Digite a inscrição estadual!';
		if($tp==1&&!$n)$x->e['n'] = 'Digite o nome!';
		if($tp==1&&strpos($n,' ')===false)$x->e['n'] = 'Digite o nome completo!';
		if($tp==1&&!$cpf)$x->e['cpf'] = 'Digite o CPF!';
		if($tp==1&&(!$_cpf||!$s->validar->cpf($cpf)))$x->e['cpf'] = 'CPF inválido!';
		if($tp==1&&$b->query("select id from cliente where id!=$id and cpf='$cpf' limit 1")->fetchObject())$x->e['cpf'] = 'Este CPF já está cadastrado!';
		//if($tp==1&&!$rg)$x->e['rg'] = 'Digite o RG!';
		if($tp==1&&!$dn)$x->e['dn'] = 'Digite a data de nascimento!';
		if($tp==1&&!$_dn||($tp==1&&$dn>$hj)||($tp==1&&$dn<$anoMinimo))$x->e['dn'] = 'Data de Nascimento inválida!';
		if(!$t1)$x->e['t1'] = 'Digite o telefone principal!';
		if(!validaFone($t1))$x->e['t1'] = 'Telefone principal inválido!';
		if($t2&&$t1==$t2)$x->e['t2'] = 'Telefone principal e telefone 2 são iguais!';
		if($t3&&$t1==$t3)$x->e['t3'] = 'Telefone principal e telefone 3 são iguais!';
		if($t2&&$t2==$t3)$x->e['t3'] = 'Telefone 2 e telefone 3 são iguais!';
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
		if(!$termos)$x->e['termos'] = 'Você precisa concordar com as Politicas o Site!';
	}elseif($tp==2&&$b->query("select id from cliente where id!=$id and cnpj='$cnpj' limit 1")->fetchObject()){
		$x->e['cnpj'] = $x->m = 'Este CNPJ já está cadastrado!';
		$x->f = 'cnpj';
		if($pg!='checkout')$x->resetCaptcha = 0;//TIRAR COMENTÁRIO DEPOIS
		if($tp==2&&$isento_insc=='NULL'&&!$ie)$x->e['ie'] = 'Digite a inscrição estadual!';
		if($tp==1&&!$n)$x->e['n'] = 'Digite o nome!';
		if($tp==1&&strpos($n,' ')===false)$x->e['n'] = 'Digite o nome completo!';
		if($tp==1&&!$cpf)$x->e['cpf'] = 'Digite o CPF!';
		if($tp==1&&(!$_cpf||!$s->validar->cpf($cpf)))$x->e['cpf'] = 'CPF inválido!';
		if($tp==1&&$b->query("select id from cliente where id!=$id and cpf='$cpf' limit 1")->fetchObject())$x->e['cpf'] = 'Este CPF já está cadastrado!';
		//if($tp==1&&!$rg)$x->e['rg'] = 'Digite o RG!';
		if($tp==1&&!$dn)$x->e['dn'] = 'Digite a data de nascimento!';
		if($tp==1&&!$_dn||($tp==1&&$dn>$hj)||($tp==1&&$dn<$anoMinimo))$x->e['dn'] = 'Data de Nascimento inválida!';
		if(!$t1)$x->e['t1'] = 'Digite o telefone principal!';
		if(!validaFone($t1))$x->e['t1'] = 'Telefone principal inválido!';
		if($t2&&$t1==$t2)$x->e['t2'] = 'Telefone principal e telefone 2 são iguais!';
		if($t3&&$t1==$t3)$x->e['t3'] = 'Telefone principal e telefone 3 são iguais!';
		if($t2&&$t2==$t3)$x->e['t3'] = 'Telefone 2 e telefone 3 são iguais!';
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
		if(!$termos)$x->e['termos'] = 'Você precisa concordar com as Politicas o Site!';
	}elseif($tp==2&&$isento_insc=='NULL'&&!$ie){
		$x->e['ie'] = $x->m = 'Digite a inscrição estadual!';
		$x->f = 'ie';
		if($pg!='checkout')$x->resetCaptcha = 0;//TIRAR COMENTÁRIO DEPOIS
		if($tp==1&&!$n)$x->e['n'] = 'Digite o nome!';
		if($tp==1&&strpos($n,' ')===false)$x->e['n'] = 'Digite o nome completo!';
		if($tp==1&&!$cpf)$x->e['cpf'] = 'Digite o CPF!';
		if($tp==1&&(!$_cpf||!$s->validar->cpf($cpf)))$x->e['cpf'] = 'CPF inválido!';
		if($tp==1&&$b->query("select id from cliente where id!=$id and cpf='$cpf' limit 1")->fetchObject())$x->e['cpf'] = 'Este CPF já está cadastrado!';
		//if($tp==1&&!$rg)$x->e['rg'] = 'Digite o RG!';
		if($tp==1&&!$dn)$x->e['dn'] = 'Digite a data de nascimento!';
		if($tp==1&&!$_dn||($tp==1&&$dn>$hj)||($tp==1&&$dn<$anoMinimo))$x->e['dn'] = 'Data de Nascimento inválida!';
		if(!$t1)$x->e['t1'] = 'Digite o telefone principal!';
		if(!validaFone($t1))$x->e['t1'] = 'Telefone principal inválido!';
		if($t2&&$t1==$t2)$x->e['t2'] = 'Telefone principal e telefone 2 são iguais!';
		if($t3&&$t1==$t3)$x->e['t3'] = 'Telefone principal e telefone 3 são iguais!';
		if($t2&&$t2==$t3)$x->e['t3'] = 'Telefone 2 e telefone 3 são iguais!';
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
		if(!$termos)$x->e['termos'] = 'Você precisa concordar com as Politicas o Site!';
	}elseif($tp==1&&!$n){
		$x->e['n'] = $x->m = 'Digite o nome!';
		$x->f = 'n';
		if($pg!='checkout')$x->resetCaptcha = 0;//TIRAR COMENTÁRIO DEPOIS
		if($tp==1&&strpos($n,' ')===false)$x->e['n'] = 'Digite o nome completo!';
		if($tp==1&&!$cpf)$x->e['cpf'] = 'Digite o CPF!';
		if($tp==1&&(!$_cpf||!$s->validar->cpf($cpf)))$x->e['cpf'] = 'CPF inválido!';
		if($tp==1&&$b->query("select id from cliente where id!=$id and cpf='$cpf' limit 1")->fetchObject())$x->e['cpf'] = 'Este CPF já está cadastrado!';
		//if($tp==1&&!$rg)$x->e['rg'] = 'Digite o RG!';
		if($tp==1&&!$dn)$x->e['dn'] = 'Digite a data de nascimento!';
		if($tp==1&&!$_dn||($tp==1&&$dn>$hj)||($tp==1&&$dn<$anoMinimo))$x->e['dn'] = 'Data de Nascimento inválida!';
		if(!$t1)$x->e['t1'] = 'Digite o telefone principal!';
		if(!validaFone($t1))$x->e['t1'] = 'Telefone principal inválido!';
		if($t2&&$t1==$t2)$x->e['t2'] = 'Telefone principal e telefone 2 são iguais!';
		if($t3&&$t1==$t3)$x->e['t3'] = 'Telefone principal e telefone 3 são iguais!';
		if($t2&&$t2==$t3)$x->e['t3'] = 'Telefone 2 e telefone 3 são iguais!';
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
		if(!$termos)$x->e['termos'] = 'Você precisa concordar com as Politicas o Site!';
	}elseif($tp==1&&strpos($n,' ')===false){
		$x->e['n'] = $x->m = 'Digite o nome completo!';
		$x->f = 'n';
		if($pg!='checkout')$x->resetCaptcha = 0;//TIRAR COMENTÁRIO DEPOIS
		if($tp==1&&!$cpf)$x->e['cpf'] = 'Digite o CPF!';
		if($tp==1&&(!$_cpf||!$s->validar->cpf($cpf)))$x->e['cpf'] = 'CPF inválido!';
		if($tp==1&&$b->query("select id from cliente where id!=$id and cpf='$cpf' limit 1")->fetchObject())$x->e['cpf'] = 'Este CPF já está cadastrado!';
		//if($tp==1&&!$rg)$x->e['rg'] = 'Digite o RG!';
		if($tp==1&&!$dn)$x->e['dn'] = 'Digite a data de nascimento!';
		if($tp==1&&!$_dn||($tp==1&&$dn>$hj)||($tp==1&&$dn<$anoMinimo))$x->e['dn'] = 'Data de Nascimento inválida!';
		if(!$t1)$x->e['t1'] = 'Digite o telefone principal!';
		if(!validaFone($t1))$x->e['t1'] = 'Telefone principal inválido!';
		if($t2&&$t1==$t2)$x->e['t2'] = 'Telefone principal e telefone 2 são iguais!';
		if($t3&&$t1==$t3)$x->e['t3'] = 'Telefone principal e telefone 3 são iguais!';
		if($t2&&$t2==$t3)$x->e['t3'] = 'Telefone 2 e telefone 3 são iguais!';
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
		if(!$termos)$x->e['termos'] = 'Você precisa concordar com as Politicas o Site!';
	}/*elseif(!$sx||$sx>2){
		$x->m = 'Selecione o sexo!';
		$x->f = 'sx';
		$x->e = 'Selecione o sexo!';
		if($tp==1&&!$cpf)$x->e['cpf'] = 'Digite o CPF!';
		if($tp==1&&(!$_cpf||!$s->validar->cpf($cpf)))$x->e['cpf'] = 'CPF inválido!';
		if($tp==1&&$b->query("select id from cliente where id!=$id and cpf='$cpf' limit 1")->fetchObject())$x->e['cpf'] = 'Este CPF já está cadastrado!';
		if($tp==1&&!$rg)$x->e['rg'] = 'Digite o RG!';
		if($tp==1&&!$dn)$x->e['dn'] = 'Digite a data de nascimento!';
		if($tp==1&&!$_dn||($tp==1&&$dn>$hj)||($tp==1&&$dn<$anoMinimo))$x->e['dn'] = 'Data de Nascimento inválida!';
		if(!$t1)$x->e['t1'] = 'Digite o telefone principal!';
		if(!validaFone($t1))$x->e['t1'] = 'Telefone principal inválido!';
		if($t2&&$t1==$t2)$x->e['t2'] = 'Telefone principal e telefone 2 são iguais!';
		if($t3&&$t1==$t3)$x->e['t3'] = 'Telefone principal e telefone 3 são iguais!';
		if($t2&&$t2==$t3)$x->e['t3'] = 'Telefone 2 e telefone 3 são iguais!';
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
		if(!$termos)$x->e['termos'] = 'Você precisa concordar com as Politicas o Site!';
	}*/
	elseif($tp==1&&!$cpf){
		$x->e['cpf'] = $x->m = 'Digite o CPF!';
		$x->f = 'cpf';
		if($pg!='checkout')$x->resetCaptcha = 0;//TIRAR COMENTÁRIO DEPOIS
		if($tp==1&&(!$_cpf||!$s->validar->cpf($cpf)))$x->e['cpf'] = 'CPF inválido!';
		if($tp==1&&$b->query("select id from cliente where id!=$id and cpf='$cpf' limit 1")->fetchObject())$x->e['cpf'] = 'Este CPF já está cadastrado!';
		//if($tp==1&&!$rg)$x->e['rg'] = 'Digite o RG!';
		if($tp==1&&!$dn)$x->e['dn'] = 'Digite a data de nascimento!';
		if($tp==1&&!$_dn||($tp==1&&$dn>$hj)||($tp==1&&$dn<$anoMinimo))$x->e['dn'] = 'Data de Nascimento inválida!';
		if(!$t1)$x->e['t1'] = 'Digite o telefone principal!';
		if(!validaFone($t1))$x->e['t1'] = 'Telefone principal inválido!';
		if($t2&&$t1==$t2)$x->e['t2'] = 'Telefone principal e telefone 2 são iguais!';
		if($t3&&$t1==$t3)$x->e['t3'] = 'Telefone principal e telefone 3 são iguais!';
		if($t2&&$t2==$t3)$x->e['t3'] = 'Telefone 2 e telefone 3 são iguais!';
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
		if(!$termos)$x->e['termos'] = 'Você precisa concordar com as Politicas o Site!';
	}elseif($tp==1&&(!$_cpf||!$s->validar->cpf($cpf))){
		$x->e['cpf'] = $x->m = 'CPF inválido!';
		$x->f = 'cpf';
		if($pg!='checkout')$x->resetCaptcha = 0;//TIRAR COMENTÁRIO DEPOIS
		if($tp==1&&$b->query("select id from cliente where id!=$id and cpf='$cpf' limit 1")->fetchObject())$x->e['cpf'] = 'Este CPF já está cadastrado!';
		//if($tp==1&&!$rg)$x->e['rg'] = 'Digite o RG!';
		if($tp==1&&!$dn)$x->e['dn'] = 'Digite a data de nascimento!';
		if($tp==1&&!$_dn||($tp==1&&$dn>$hj)||($tp==1&&$dn<$anoMinimo))$x->e['dn'] = 'Data de Nascimento inválida!';
		if(!$t1)$x->e['t1'] = 'Digite o telefone principal!';
		if(!validaFone($t1))$x->e['t1'] = 'Telefone principal inválido!';
		if($t2&&$t1==$t2)$x->e['t2'] = 'Telefone principal e telefone 2 são iguais!';
		if($t3&&$t1==$t3)$x->e['t3'] = 'Telefone principal e telefone 3 são iguais!';
		if($t2&&$t2==$t3)$x->e['t3'] = 'Telefone 2 e telefone 3 são iguais!';
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
		if(!$termos)$x->e['termos'] = 'Você precisa concordar com as Politicas o Site!';
	}elseif($tp==1&&$b->query("select id from cliente where id!=$id and cpf='$cpf' limit 1")->fetchObject()){
		$x->e['cpf'] = $x->m = 'Este CPF já está cadastrado!';
		$x->f = 'cpf';
		if($pg!='checkout')$x->resetCaptcha = 0;//TIRAR COMENTÁRIO DEPOIS
		//if($tp==1&&!$rg)$x->e['rg'] = 'Digite o RG!';
		if($tp==1&&!$dn)$x->e['dn'] = 'Digite a data de nascimento!';
		if($tp==1&&!$_dn||($tp==1&&$dn>$hj)||($tp==1&&$dn<$anoMinimo))$x->e['dn'] = 'Data de Nascimento inválida!';
		if(!$t1)$x->e['t1'] = 'Digite o telefone principal!';
		if(!validaFone($t1))$x->e['t1'] = 'Telefone principal inválido!';
		if($t2&&$t1==$t2)$x->e['t2'] = 'Telefone principal e telefone 2 são iguais!';
		if($t3&&$t1==$t3)$x->e['t3'] = 'Telefone principal e telefone 3 são iguais!';
		if($t2&&$t2==$t3)$x->e['t3'] = 'Telefone 2 e telefone 3 são iguais!';
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
		if(!$termos)$x->e['termos'] = 'Você precisa concordar com as Politicas o Site!';
	}
/*elseif($tp==1&&!$rg){
		//$x->e['rg'] = $x->m = 'Digite o RG!';
		//$x->f = 'rg';
		if($pg!='checkout')$x->resetCaptcha = 0;//TIRAR COMENTÁRIO DEPOIS
		if($tp==1&&!$dn)$x->e['dn'] = 'Digite a data de nascimento!';
		if($tp==1&&!$_dn||($tp==1&&$dn>$hj)||($tp==1&&$dn<$anoMinimo))$x->e['dn'] = 'Data de Nascimento inválida!';
		if(!$t1)$x->e['t1'] = 'Digite o telefone principal!';
		if(!validaFone($t1))$x->e['t1'] = 'Telefone principal inválido!';
		if($t2&&$t1==$t2)$x->e['t2'] = 'Telefone principal e telefone 2 são iguais!';
		if($t3&&$t1==$t3)$x->e['t3'] = 'Telefone principal e telefone 3 são iguais!';
		if($t2&&$t2==$t3)$x->e['t3'] = 'Telefone 2 e telefone 3 são iguais!';
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
		if(!$termos)$x->e['termos'] = 'Você precisa concordar com as Politicas o Site!';
	}*/
	elseif($tp==1&&!$dn){
		$x->e['dn'] = $x->m = 'Digite a data de nascimento!';
		$x->f = 'dn';
		if($pg!='checkout')$x->resetCaptcha = 0;//TIRAR COMENTÁRIO DEPOIS
		if(!$t1)$x->e['t1'] = 'Digite o telefone principal!';
		if(!validaFone($t1))$x->e['t1'] = 'Telefone principal inválido!';
		if($t2&&$t1==$t2)$x->e['t2'] = 'Telefone principal e telefone 2 são iguais!';
		if($t3&&$t1==$t3)$x->e['t3'] = 'Telefone principal e telefone 3 são iguais!';
		if($t2&&$t2==$t3)$x->e['t3'] = 'Telefone 2 e telefone 3 são iguais!';
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
		if(!$termos)$x->e['termos'] = 'Você precisa concordar com as Politicas o Site!';
	}elseif($tp==1&&!$_dn||($tp==1&&$dn>$hj)||($tp==1&&$dn<$anoMinimo)){
		$x->e['dn'] = $x->m = 'Data de nascimento inválida!';
		$x->f = 'dn';
		if($pg!='checkout')$x->resetCaptcha = 0;//TIRAR COMENTÁRIO DEPOIS
		if(!$t1)$x->e['t1'] = 'Digite o telefone principal!';
		if(!validaFone($t1))$x->e['t1'] = 'Telefone principal inválido!';
		if($t2&&$t1==$t2)$x->e['t2'] = 'Telefone principal e telefone 2 são iguais!';
		if($t3&&$t1==$t3)$x->e['t3'] = 'Telefone principal e telefone 3 são iguais!';
		if($t2&&$t2==$t3)$x->e['t3'] = 'Telefone 2 e telefone 3 são iguais!';
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
		if(!$termos)$x->e['termos'] = 'Você precisa concordar com as Politicas o Site!';
	}elseif(!$t1){
		$x->e['t1'] = $x->m = 'Digite o telefone principal!';
		$x->f = 't1';
		if($pg!='checkout')$x->resetCaptcha = 0;//TIRAR COMENTÁRIO DEPOIS
		if($t2&&$t1==$t2)$x->e['t2'] = 'Telefone principal e telefone 2 são iguais!';
		if($t3&&$t1==$t3)$x->e['t3'] = 'Telefone principal e telefone 3 são iguais!';
		if($t2&&$t2==$t3)$x->e['t3'] = 'Telefone 2 e telefone 3 são iguais!';
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
		if(!$termos)$x->e['termos'] = 'Você precisa concordar com as Politicas o Site!';
	}elseif(!validaFone($t1)){
		$x->e['t1'] = $x->m = 'O telefone principal é inválido!';
		$x->f = 't1';
		if($t2&&$t1==$t2)$x->e['t2'] = 'Telefone principal e telefone 2 são iguais!';
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
	}elseif($t2&&$t1==$t2){
		$x->e['t2'] = $x->m = 'Telefone principal e telefone 2 são iguais!';
		$x->f = 't2';
		if($pg!='checkout')$x->resetCaptcha = 0;//TIRAR COMENTÁRIO DEPOIS
		if($t3&&$t1==$t3)$x->e['t3'] = 'Telefone principal e telefone 3 são iguais!';
		if($t2&&$t2==$t3)$x->e['t3'] = 'Telefone 2 e telefone 3 são iguais!';
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
		if(!$termos)$x->e['termos'] = 'Você precisa concordar com as Politicas o Site!';
	}elseif($t3&&$t1==$t3){
		$x->e['t3'] = $x->m = 'Telefone principal e telefone 3 são iguais!';
		$x->f = 't3';
		if($pg!='checkout')$x->resetCaptcha = 0;//TIRAR COMENTÁRIO DEPOIS
		if($t2&&$t2==$t3)$x->e['t3'] = 'Telefone 2 e telefone 3 são iguais!';
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
		if(!$termos)$x->e['termos'] = 'Você precisa concordar com as Politicas o Site!';
	}elseif($t2&&$t2==$t3){
		$x->e['t3'] = $x->m = 'Telefone 2 e telefone 3 são iguais!';
		$x->f = 't3';
		if($pg!='checkout')$x->resetCaptcha = 0;//TIRAR COMENTÁRIO DEPOIS
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
		if(!$termos)$x->e['termos'] = 'Você precisa concordar com as Politicas o Site!';
	}elseif(!$cep){
		$x->e['cep'] = $x->m = 'Digite o CEP!';
		$x->f = 'cep';
		if($pg!='checkout')$x->resetCaptcha = 0;//TIRAR COMENTÁRIO DEPOIS
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
		if(!$termos)$x->e['termos'] = 'Você precisa concordar com as Politicas o Site!';
	}elseif(!$_cep){
		$x->e['cep'] = $x->m = 'CEP inválido!';
		$x->f = 'cep';
		if($pg!='checkout')$x->resetCaptcha = 0;//TIRAR COMENTÁRIO DEPOIS
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
		if(!$termos)$x->e['termos'] = 'Você precisa concordar com as Politicas o Site!';
	}elseif(!$rua){
		$x->e['rua'] = $x->m = 'Digite o logradouro!';
		$x->f = 'rua';
		if($pg!='checkout')$x->resetCaptcha = 0;//TIRAR COMENTÁRIO DEPOIS
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
		if(!$termos)$x->e['termos'] = 'Você precisa concordar com as Politicas o Site!';
	}elseif(!$sem_num&&!$num){
		$x->e['num'] = $x->m = 'Digite o número residencial!';
		$x->f = 'num';
		if($pg!='checkout')$x->resetCaptcha = 0;//TIRAR COMENTÁRIO DEPOIS
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
		if(!$termos)$x->e['termos'] = 'Você precisa concordar com as Politicas o Site!';
	}/*elseif(!$comp){
		$x->m = 'Digite o Complemento Residencial!';
		$x->f = 'comp';
		if($pg!='checkout')$x->resetCaptcha = 0;//TIRAR COMENTÁRIO DEPOIS
	}*/elseif(!$bairro){
		$x->e['bairro'] = $x->m = 'Digite o bairro!';
		$x->f = 'bairro';
		if($pg!='checkout')$x->resetCaptcha = 0;//TIRAR COMENTÁRIO DEPOIS
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
		if(!$termos)$x->e['termos'] = 'Você precisa concordar com as Politicas o Site!';
	}elseif(!$city){
		$x->e['city'] = $x->m = 'Digite a cidade!';
		$x->f = 'city';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
		if(!$termos)$x->e['termos'] = 'Você precisa concordar com as Politicas o Site!';
	}elseif(!$uf){
		$x->e['uf'] = $x->m = 'Selecione o estado!';
		$x->f = 'uf';
		if($pg!='checkout')$x->resetCaptcha = 0;//TIRAR COMENTÁRIO DEPOIS
	}/*elseif(!$termos){
		$x->e['termos'] = $x->m = 'Você precisa concordar com as Politicas o Site!';
		$x->f = 'termos';
		if($pg!='checkout')$x->resetCaptcha = 0;
	}elseif($pg!='checkout'&&!$request->success)$x->m = 'Confirme o reCAPTCHA!';*/
	else{
		$p = $senha?sha1($senha):$rs->p;
		$n = $n?$n:$nc;
		$t = $t?$t:$tc;
		$num = $sem_num?"S/N":$num;
		$x->up = $id?1:0;
		if(!$id&&$b->exec("insert into cliente (dc) values(now())")){
			$id = $b->lastInsertId();
			$send->subject = "Dados de Acesso Shark Pro";
			$telefone = '(19) 2146-0439';
			/*$send->html = 
"<strong>Nome:</strong> ".strh($n)."<br/>
<strong>E-mail:</strong> ".strh($email)."<br/>
<strong>Senha:</strong> ".strh($senha)."<br/>
<strong>Link:</strong> <a href=\"{$s->base}login\">Visite o Site</a><br/>";*/
			$send->html = 
'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Bem vindo '.strh($n).'</title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<meta name="viewport" content="width=device-width;initial-scale=1.0;maximum-scale=1.0;"/>
<style>
body{-webkit-text-size-adjust:none;-ms-text-size-adjust:none}
body{margin:0;padding:0}
table{border-collapse:collapse}
table td{border-collapse:collapse}
a{color:#FFFFFF;text-decoration:none}
</style>
</head>
<body bgcolor="edf7f9" style="background-color:#ffffff;width:100%;margin:0px;padding:0px;">
<table class="mainTable" bgcolor="edf7f9" border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td align="center">
      <table class="containerWide" bgcolor="333333" border="0" align="center" cellpadding="0" cellspacing="0" width="100%" style="background-color:#333333;border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt;" >
        <tr>
          <td><table class="containerBox" border="0" align="center" cellpadding="0" cellspacing="0" width="600" style="border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt;">
              <tr>
                <td height="10"></td>
                <td height="10"></td>
              </tr>
              <tr>
                <td align="left" style="color:#cccccc;font-family:Helvetica,Arial,sans-serif;font-size:13px;line-height:13px;"><a href="'.$s->base.'login" target="_blank" style="color:#cccccc;text-decoration:none;">Área do Cliente</a></td>
                <td align="right" style="color:#cccccc;font-family:Helvetica,Arial,sans-serif;font-size:13px;line-height:13px;"><a href="mailto:contato@sharkpro.com.br" target="_blank" style="color:#cccccc;text-decoration:none;">contato@sharkpro.com.br</a></td>
              </tr>
              <tr>
                <td height="10"></td>
                <td height="10"></td>
              </tr>
            </table></td>
        </tr>
      </table>
      <table class="containerWide" bgcolor="edf7f9" border="0" align="center" cellpadding="0" cellspacing="0" width="100%" style="background-color:#ffffff;border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt;"  >
        <tr>
          <td>
            <table class="containerBox" border="0" align="center" cellpadding="0" cellspacing="0" width="600"  style="border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt;">
              <tr>
                <td height="15"></td>
              </tr>
              <tr>
                <td align="center"><table class="column" border="0" align="right" cellpadding="0" cellspacing="0" width="150" style="border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt;">
                    <tr>
                      <td class="textColor" align="right" valign="top" style="color:#ffffff;font-family:Helvetica,Arial,sans-serif;font-size:14px;padding-top:10px;padding-bottom: 10px;padding-right: 25px;font-weight:300;background:#211d1e;"><a style="color:#ffffff;text-decoration:none;border-width:0px;border-style:solid;border-color:#211d1e;font-family:Helvetica,Arial,sans-serif;font-size:15px;font-weight:600;line-height:20px;text-align:center;">'.$telefone.'</a></td>
                    </tr>
                    <tr>
                      <td height="10"></td>
                    </tr>
                  </table>
                  <table class="column" border="0" align="left" cellpadding="0" cellspacing="0" width="250" style="border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt;">
                    <tr>
                      <td align="left"><a href="'.$s->base.'"><img src="'.$s->base.'assets/img/email/logo-top.png" alt="Shark Pro" border="0" style="border-style:none;display:block;"/></a></td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td height="5"></td>
              </tr>
            </table></td>
        </tr>
      </table>
      <table class="containerWide" bgcolor="edf7f9" border="0" align="center" cellpadding="0" cellspacing="0" width="100%" style="background-color:#ffffff;border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt;"  >
        <tr>
          <td height="20" style="height:20px;"></td>
        </tr>
      </table>
      <table class="containerWide" bgcolor="edf7f9" border="0" align="center" cellpadding="0" cellspacing="0" width="100%" style="background-color:#ffffff;border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt;"  >
        <tr>
          <td>
            <table class="containerBox" border="0" align="center" cellpadding="0" cellspacing="0" width="600"  style="border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt;">
              <tr>
                <td align="left"><img class="hero" src="'.$s->base.'assets/img/email/acesso.jpg" alt="Shark Pro" width="600" border="0" style="width:600px;border-style:none;display:block;"   /></td>
              </tr>
            </table></td>
        </tr>
      </table>
      <table class="containerWide" border="0" align="center" bgcolor="edf7f9" cellpadding="0" cellspacing="0" width="100%" style="background-color:#ffffff;border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt;" >
        <tr>
          <td>
            <table class="containerBox" border="0" align="center" cellpadding="0" cellspacing="0" width="600" bgcolor="211d1e" style="background-color:#211d1e;border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt;">
              <tr>
                <td height="30">&nbsp;</td>
                <td class="noMobile">&nbsp;</td>
                <td class="noMobile">&nbsp;</td>
              </tr>
              <tr>
                <td width="25" class="noMobile">&nbsp;</td>
                <td style="color:#FFFFFF;font-family:Helvetica,Arial,sans-serif;font-size:16px;line-height:22px;font-weight:300;">
                  <table class="column" border="0" align="left" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt;">
                    <tr>
                      <td width="10" class="noDesktop">&nbsp;</td>
                      <td align="left" style="color:#FFFFFF;font-family:Helvetica,Arial,sans-serif;font-size:16px;line-height:22px;font-weight:600;text-transform:capitalize !important" > ÁREA DO CLIENTE </td>
                      <td width="10" class="noDesktop">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="10" class="noDesktop">&nbsp;</td>
                      <td height="10">&nbsp;</td>
                      <td width="10" class="noDesktop">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="10" class="noDesktop">&nbsp;</td>
                      <td align="left" style="color:#FFFFFF;font-family:Helvetica,Arial,sans-serif;font-size:16px;line-height:22px;font-weight:300;" >Essa área é exclusiva para você, cliente da Shark Pro.<br />
                        Através dos dados de acesso, que seguem abaixo, você poderá realizar suas compras, colocar produtos em sua lista de desejo e conferir o andamento do seu pedido.<br />
                        Clique no link abaixo para acessar a área de login do nosso site.</td>
                      <td width="10" class="noDesktop">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="10" class="noDesktop">&nbsp;</td>
                      <td height="10">&nbsp;</td>
                      <td width="10" class="noDesktop">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="10" class="noDesktop">&nbsp;</td>
                      <td align="left" style="padding-top:10px;padding-bottom:10px;" ><a href="'.$s->base.'login" style="color:#ffffff;border-color:#ffffff;border-width:2px;border-style:solid;text-decoration:none;padding-left:10px;padding-right:10px;padding-top:8px;padding-bottom:8px;border-radius:4px;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:600;line-height:20px;text-align:center;">LOGIN</a></td>
                      <td width="10" class="noDesktop">&nbsp;</td>
                    </tr>
                  </table></td>
                <td width="25" class="noMobile">&nbsp;</td>
              </tr>
              <tr>
                <td height="30">&nbsp;</td>
                <td class="noMobile">&nbsp;</td>
                <td class="noMobile">&nbsp;</td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <table class="containerWide" border="0" align="center" bgcolor="edf7f9" cellpadding="0" cellspacing="0" width="100%" style="background-color:#ffffff;border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt;" >
        <tr>
          <td>
            <table class="containerBox" border="0" align="center" cellpadding="0" cellspacing="0" width="600" bgcolor="ffffff" style="background-color:#ffffff;border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt;">
              <tr>
                <td height="30"></td>
                <td class="noMobile"></td>
                <td class="noMobile"></td>
              </tr>
              <tr>
                <td width="25" class="noMobile"></td>
                <td style="color:#333333;font-family:Helvetica,Arial,sans-serif;font-size:16px;line-height:22px;font-weight:300;">
                  
                  <table class="column" border="0" align="left" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt;">
                    <tr>
                      <td width="10" class="noDesktop">&nbsp;</td>
                      <td align="left"  style="color:#333333;font-family:Helvetica,Arial,sans-serif;font-size:16px;line-height:22px;font-weight:600;"> DADOS DE ACESSO </td>
                      <td width="10" class="noDesktop">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="10" class="noDesktop">&nbsp;</td>
                      <td height="10">&nbsp;</td>
                      <td width="10" class="noDesktop">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="10" class="noDesktop">&nbsp;</td>
                      <td align="left"  style="color:#333333;font-family:Helvetica,Arial,sans-serif;font-size:16px;line-height:22px;font-weight:300;">
					  	Nome:<strong>'.strh($n).'</strong><br />
                        E-mail:<strong>'.strh($email).'</strong><br />
                        Senha:<strong>'.strh($senha).'</strong></td>
                      <td width="10" class="noDesktop">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="10" class="noDesktop">&nbsp;</td>
                      <td height="10">&nbsp;</td>
                      <td width="10" class="noDesktop">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="10" class="noDesktop">&nbsp;</td>
                      <td align="left" style="padding-top:10px;padding-bottom:10px;" ><table border="0" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt;">
                          <tr>
                            <td align="left" style="background-color:#211d1e;border-radius:4px;padding-left:10px;padding-right:10px;padding-top:8px;padding-bottom:8px;text-align:center;"><a href="'.$s->base.'login" target="_blank" style="color:#ffffff;text-decoration:none;border-width:0px;border-style:solid;border-color:#211d1e;font-family:Helvetica,Arial,sans-serif;font-size:15px;font-weight:600;line-height:20px;text-align:center;" >LINK DE ACESSO</a></td>
                          </tr>
                        </table></td>
                      <td width="10" class="noDesktop">&nbsp;</td>
                    </tr>
                  </table></td>
                <td width="25" class="noMobile">&nbsp;</td>
              </tr>
              <tr>
                <td height="30">&nbsp;</td>
                <td class="noMobile">&nbsp;</td>
                <td class="noMobile">&nbsp;</td>
              </tr>
              <tr>
                <td height="5" bgcolor="211d1e" style="line-height:0px;"></td>
                <td height="5" bgcolor="211d1e" style="line-height:0px;" class="noMobile"></td>
                <td height="5" bgcolor="211d1e" style="line-height:0px;" class="noMobile"></td>
              </tr>
            </table>
            <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt;">
              <tr>
                <td height="10">&nbsp;</td>
                <td class="noMobile">&nbsp;</td>
                <td class="noMobile">&nbsp;</td>
              </tr>
            </table></td>
        </tr>
      </table>
      <table class="containerWide" bgcolor="edf7f9" border="0" align="center" cellpadding="0" cellspacing="0" width="100%" style="background-color:#ffffff;border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt;"  >
        <tr>
          <td>
            <table class="containerBox" border="0" align="center" cellpadding="0" cellspacing="0" width="600" style="border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt;">
              <tr>
                <td height="10"></td>
                <td></td>
              </tr>
              <tr>
                <td align="center" style="color:#666666;font-family:Helvetica,Arial,sans-serif;font-size:13px;line-height:20px;">
					<a style="color:#211d1e;text-decoration:none;">'.$telefone.'</a><br />
					<a href="mailto:contato@sharkpro.com.br" style="color:#211d1e;text-decoration:none;">contato@sharkpro.com.br</a> | <a href="mailto:pedidos@sharkpro.com.br" style="color:#211d1e;text-decoration:none;">pedidos@sharkpro.com.br</a><br/>
					Rua Barão do Rio Branco, 575 - Centro, Capivari - SP
				</td>
              </tr>
              <tr>
                <td height="10"></td>
                <td></td>

              </tr>
            </table></td>
        </tr>
      </table>
  </tr>
</table>
</body>
</html>';
			$send->to = array($email);
			$send->bcc = array('rodrigo@alquati.com.br');
			$x->send=$s->send($send);

			$ck = $_SESSION['cookie_cart'];
			$b->query("update cliente set cookie='$ck' where id='$id' limit 1");
			$sct = $b->query("select * from cart_temp where cookie='$ck' limit 1");
			if($sct->rowCount()){
				$rct = $sct->fetchObject();
				$b->query("insert into cart (idu,i,q,v) values('$id','{$rct->i}','{$rct->q}','{$rct->v}')");
				$idcar = $b->lastInsertId();
				$sat = $b->query("select * from cart_ax_temp where idc='{$rct->id}'");
				while($rat=$sat->fetchObject())$b->query("insert into cart_ax (idc,idp,q,v,t,p,w) values('$idcar','{$rat->idp}','{$rat->q}','{$rat->v}','{$rat->t}','{$rat->p}','{$rat->w}')");
				$rt = $b->query("select sum(t) as t,count(*) as i,sum(q) as q from cart_ax where idc='$idcar'")->fetchObject();
				$b->exec("update cart set t='{$rt->t}',i='{$rt->i}',q='{$rt->q}' where id='$idcar'");
				$b->exec("delete from cart_temp where id='{$rct->id}'");
				$b->exec("delete from cart_ax_temp where idc='{$rct->id}'");
			}
			$s->idc = $_SESSION['idc'] = $id+0;
			$s->nome = $_SESSION['nome'] = $n;
			$s->user = $_SESSION['user'] = $email;
			$s->email = $_SESSION['email'] = $email;
			$s->tipo = $_SESSION['tipo'] = 3;
			$s->cli = $_SESSION['cli'] = 1;
			if($sct->rowCount())$x->l = 'checkout';
			else $x->l = 'produtos';
		}
		if($b->exec($x->sql="update cliente set s=$S,p='$p',n='$n',t='$t',email='$email',dn='$dn',cpf='$cpf',rg='$rg',t1='$t1',t2='$t2',tp='$tp',r='$r',cnpj='$cnpj',ie='$ie',cep='$cep',rua='$rua',num='$num',sem_num='$sem_num',comp='$comp',bairro='$bairro',city='$city',uf='$uf' where id=$id limit 1")){
			if($x->up)$b->exec("update cliente set da=now() where id=$id limit 1");
			$x->ok = 1;
			$x->m = 'Cliente '.($x->up?'alterado':'cadastrado').' com sucesso!';
		}else $x->m = $x->up&&++$x->noup?'Nenhum campo para alterar!':'Erro ao cadastrar o cliente!';
	}
}