<?
$id = 0;
$idg = 1;
$a = 1;
$n = strps('n');
$email = strps('email',1);

if(!$email)$x->news = 'Digite seu E-mail!';
elseif(!preg_match($emailRE,$email))$x->news = 'E-mail inválido!';
elseif($rs=$b->query("select email from email where idg=$idg and email='$email'")->fetchObject())$x->news = 'Este e-mail já está cadastrado!';
else{
	$x->up = $id?1:0;
	if(!$id&&$b->exec("insert into email (dc,idg)values(now(),$idg)"))$id = $b->lastInsertId();
	if($b->exec("update email set email='$email' where id=$id limit 1")){
		$x->ok = 1;
		$x->news = 'E-mail cadastrado com sucesso!';
	}else $x->news = $x->up?'Seu E-mail já está cadastrado!':'Erro ao cadastar seu E-mail, tente novamente!';
}



?>