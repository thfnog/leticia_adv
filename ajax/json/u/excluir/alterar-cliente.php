<?
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

	if($id&&!$b->query("select id from cliente where id=$id limit 1")->fetchObject())$x->m = 'Este cliente não existe!';
	//elseif(!$u)$x->m = 'Digite o usuário!';
	//elseif($b->query("select id from cliente where id!=$id and u='$u' limit 1")->fetchObject())$x->m = 'Este nome de usuário está indisponível!';
	elseif(!$email){
		$x->e['email'] = $x->m = 'Digite o E-mail!';
		$x->f = 'email';
	}elseif(!preg_match($emailRE,$email)){
		$x->e['email'] = $x->m = 'E-mail inválido!';
		$x->f = 'email';
	}elseif($b->query("select id from cliente where id!=$id and email='$email' limit 1")->fetchObject()){
		$x->e['email'] = $x->m = 'Este e-mail não está disponível!';
		$x->f = 'email';
	}elseif(!$id&&!$senha){
		$x->e['p'] = $x->m = 'Digite a senha!';
		$x->f = 'p';
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
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
	}elseif(!$id&&!$p2){
		$x->e['p2'] = $x->m = 'Digite a confirmação de senha!';
		$x->f = 'p2';
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
		if($t2&&$t1==$t2)$x->e['t2'] = 'Telefone principal e telefone 2 são iguais!';
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
	}elseif(!$tp||$tp!=1&&$tp!=2){
		$x->e['tp'] = $x->m = 'Selecione o tipo de cadastro!';
		$x->f = 'tp';
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
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
	}elseif($tp==2&&!$nc){
		$x->e['nc'] = $x->m = 'Digite o nome!';
		$x->f = 'nc';
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
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
	}elseif($tp==2&&strpos($nc,' ')===false){
		$x->e['nc'] = $x->m = 'Digite o nome completo!';
		$x->f = 'nc';
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
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
	}elseif($tp==2&&!$r){
		$x->e['r'] = $x->m = 'Digite a razão social!';
		$x->f = 'r';
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
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
	}elseif($tp==2&&!$cnpj){
		$x->e['cnpj'] = $x->m = 'Digite o CNPJ!';
		$x->f = 'cnpj';
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
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
	}elseif($tp==2&&(!$_cnpj||!$s->validar->cnpj($cnpj))){
		$x->e['cnpj'] = $x->m = 'CNPJ inválido!';
		$x->f = 'cnpj';
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
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
	}elseif($tp==2&&$b->query("select id from cliente where id!=$id and cnpj='$cnpj' limit 1")->fetchObject()){
		$x->e['cnpj'] = $x->m = 'Este CNPJ já está cadastrado!';
		$x->f = 'cnpj';
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
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
	}elseif($tp==2&&$isento_insc=='NULL'&&!$ie){
		$x->e['ie'] = $x->m = 'Digite a inscrição estadual!';
		$x->f = 'ie';
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
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
	}elseif($tp==1&&!$n){
		$x->e['n'] = $x->m = 'Digite o nome!';
		$x->f = 'n';
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
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
	}elseif($tp==1&&strpos($n,' ')===false){
		$x->e['n'] = $x->m = 'Digite o nome completo!';
		$x->f = 'n';
		if($tp==1&&!$cpf)$x->e['cpf'] = 'Digite o CPF!';
		if($tp==1&&(!$_cpf||!$s->validar->cpf($cpf)))$x->e['cpf'] = 'CPF inválido!';
		if($tp==1&&$b->query("select id from cliente where id!=$id and cpf='$cpf' limit 1")->fetchObject())$x->e['cpf'] = 'Este CPF já está cadastrado!';
		//if($tp==1&&!$rg)$x->e['rg'] = 'Digite o RG!';
		if($tp==1&&!$dn)$x->e['dn'] = 'Digite a data de nascimento!';
		if($tp==1&&!$_dn||($tp==1&&$dn>$hj)||($tp==1&&$dn<$anoMinimo))$x->e['dn'] = 'Data de Nascimento inválida!';
		if(!$t1)$x->e['t1'] = 'Digite o telefone principal!';
		if(!validaFone($t1))$x->e['t1'] = 'Telefone principal inválido!';
		if($t2&&$t1==$t2)$x->e['t2'] = 'Telefone principal e telefone 2 são iguais!';
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
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
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
	}*/
	elseif($tp==1&&!$cpf){
		$x->e['cpf'] = $x->m = 'Digite o CPF!';
		$x->f = 'cpf';
		if($tp==1&&(!$_cpf||!$s->validar->cpf($cpf)))$x->e['cpf'] = 'CPF inválido!';
		if($tp==1&&$b->query("select id from cliente where id!=$id and cpf='$cpf' limit 1")->fetchObject())$x->e['cpf'] = 'Este CPF já está cadastrado!';
		//if($tp==1&&!$rg)$x->e['rg'] = 'Digite o RG!';
		if($tp==1&&!$dn)$x->e['dn'] = 'Digite a data de nascimento!';
		if($tp==1&&!$_dn||($tp==1&&$dn>$hj)||($tp==1&&$dn<$anoMinimo))$x->e['dn'] = 'Data de Nascimento inválida!';
		if(!$t1)$x->e['t1'] = 'Digite o telefone principal!';
		if(!validaFone($t1))$x->e['t1'] = 'Telefone principal inválido!';
		if($t2&&$t1==$t2)$x->e['t2'] = 'Telefone principal e telefone 2 são iguais!';
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
	}elseif($tp==1&&(!$_cpf||!$s->validar->cpf($cpf))){
		$x->e['cpf'] = $x->m = 'CPF inválido!';
		$x->f = 'cpf';
		if($tp==1&&$b->query("select id from cliente where id!=$id and cpf='$cpf' limit 1")->fetchObject())$x->e['cpf'] = 'Este CPF já está cadastrado!';
		//if($tp==1&&!$rg)$x->e['rg'] = 'Digite o RG!';
		if($tp==1&&!$dn)$x->e['dn'] = 'Digite a data de nascimento!';
		if($tp==1&&!$_dn||($tp==1&&$dn>$hj)||($tp==1&&$dn<$anoMinimo))$x->e['dn'] = 'Data de Nascimento inválida!';
		if(!$t1)$x->e['t1'] = 'Digite o telefone principal!';
		if(!validaFone($t1))$x->e['t1'] = 'Telefone principal inválido!';
		if($t2&&$t1==$t2)$x->e['t2'] = 'Telefone principal e telefone 2 são iguais!';
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
	}elseif($tp==1&&$b->query("select id from cliente where id!=$id and cpf='$cpf' limit 1")->fetchObject()){
		$x->e['cpf'] = $x->m = 'Este CPF já está cadastrado!';
		$x->f = 'cpf';
		//if($tp==1&&!$rg)$x->e['rg'] = 'Digite o RG!';
		if($tp==1&&!$dn)$x->e['dn'] = 'Digite a data de nascimento!';
		if($tp==1&&!$_dn||($tp==1&&$dn>$hj)||($tp==1&&$dn<$anoMinimo))$x->e['dn'] = 'Data de Nascimento inválida!';
		if(!$t1)$x->e['t1'] = 'Digite o telefone principal!';
		if(!validaFone($t1))$x->e['t1'] = 'Telefone principal inválido!';
		if($t2&&$t1==$t2)$x->e['t2'] = 'Telefone principal e telefone 2 são iguais!';
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
	}
/*elseif($tp==1&&!$rg){
		//$x->e['rg'] = $x->m = 'Digite o RG!';
		//$x->f = 'rg';
		if($tp==1&&!$dn)$x->e['dn'] = 'Digite a data de nascimento!';
		if($tp==1&&!$_dn||($tp==1&&$dn>$hj)||($tp==1&&$dn<$anoMinimo))$x->e['dn'] = 'Data de Nascimento inválida!';
		if(!$t1)$x->e['t1'] = 'Digite o telefone principal!';
		if(!validaFone($t1))$x->e['t1'] = 'Telefone principal inválido!';
		if($t2&&$t1==$t2)$x->e['t2'] = 'Telefone principal e telefone 2 são iguais!';
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
	}*/
	elseif($tp==1&&!$dn){
		$x->e['dn'] = $x->m = 'Digite a data de nascimento!';
		$x->f = 'dn';
		if(!$t1)$x->e['t1'] = 'Digite o telefone principal!';
		if(!validaFone($t1))$x->e['t1'] = 'Telefone principal inválido!';
		if($t2&&$t1==$t2)$x->e['t2'] = 'Telefone principal e telefone 2 são iguais!';
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
	}elseif($tp==1&&!$_dn||($tp==1&&$dn>$hj)||($tp==1&&$dn<$anoMinimo)){
		$x->e['dn'] = $x->m = 'Data de nascimento inválida!';
		$x->f = 'dn';
		if($pg!='checkout')$x->resetCaptcha = 0;//TIRAR COMENTÁRIO DEPOIS
		if(!$t1)$x->e['t1'] = 'Digite o telefone principal!';
		if(!validaFone($t1))$x->e['t1'] = 'Telefone principal inválido!';
		if($t2&&$t1==$t2)$x->e['t2'] = 'Telefone principal e telefone 2 são iguais!';
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
		if($t2&&$t1==$t2)$x->e['t2'] = 'Telefone principal e telefone 2 são iguais!';
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
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
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
	}elseif($t3&&$t1==$t3){
		$x->e['t3'] = $x->m = 'Telefone principal e telefone 3 são iguais!';
		$x->f = 't3';
		if($t2&&$t2==$t3)$x->e['t3'] = 'Telefone 2 e telefone 3 são iguais!';
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
	}elseif($t2&&$t2==$t3){
		$x->e['t3'] = $x->m = 'Telefone 2 e telefone 3 são iguais!';
		$x->f = 't3';
		if(!$cep)$x->e['cep'] = 'Digite o CEP!';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
	}elseif(!$cep){
		$x->e['cep'] = $x->m = 'Digite o CEP!';
		$x->f = 'cep';
		if(!$_cep)$x->e['cep'] = 'CEP inválido!';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
	}elseif(!$_cep){
		$x->e['cep'] = $x->m = 'CEP inválido!';
		$x->f = 'cep';
		if(!$rua)$x->e['rua'] = 'Digite o logradouro';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
	}elseif(!$rua){
		$x->e['rua'] = $x->m = 'Digite o logradouro!';
		$x->f = 'rua';
		if(!$sem_num&&!$num)$x->e['num'] = 'Digite o número residencial!';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
	}elseif(!$sem_num&&!$num){
		$x->e['num'] = $x->m = 'Digite o número residencial!';
		$x->f = 'num';
		if(!$bairro)$x->e['bairro'] = 'Digite o bairro!';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
	}/*elseif(!$comp){
		$x->m = 'Digite o Complemento Residencial!';
		$x->f = 'comp';
	}*/elseif(!$bairro){
		$x->e['bairro'] = $x->m = 'Digite o bairro!';
		$x->f = 'bairro';
		if(!$city)$x->e['city'] = 'Digite a cidade!';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
	}elseif(!$city){
		$x->e['city'] = $x->m = 'Digite a cidade!';
		$x->f = 'city';
		if(!$uf)$x->e['uf'] = 'Selecione o estado!';
	}elseif(!$uf){
		$x->e['uf'] = $x->m = 'Selecione o estado!';
		$x->f = 'uf';
	}//elseif(!$request->success)$x->m = 'Confirme o reCAPTCHA!';
	else{
		$p = $senha?sha1($senha):$rs->p;
		$n = $n?$n:$nc;
		$t = $t?$t:$tc;
		$num = $sem_num?"S/N":$num;
		$x->up = 1;
		if($b->exec($x->sql="update cliente set s=$S,p='$p',n='$n',t='$t',email='$email',dn='$dn',cpf='$cpf',rg='$rg',t1='$t1',t2='$t2',tp='$tp',r='$r',cnpj='$cnpj',ie='$ie',cep='$cep',rua='$rua',num='$num',sem_num='$sem_num',comp='$comp',bairro='$bairro',city='$city',uf='$uf' where id=$id limit 1")){
			if($x->up)$b->exec("update cliente set da=now() where id=$id limit 1");
			$x->ok = 1;
			$x->m = 'Cliente alterado com sucesso!';
		}else $x->m = 'Nenhum campo para alterar!';
	}
}
?>