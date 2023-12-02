<?
if(!$s->idc){
	$email = strps($x->c='email',1);
	$site = "{$s->base}";

	if(!$email)$x->m = 'Digite o e-mail!';
	elseif(!preg_match($emailRE,$email))$x->m = 'E-mail inválido!';
	elseif($rs=$b->query("select id,cod,n from cliente where email='$email' limit 1")->fetchObject()){
		$id = $rs->id+0;
		$cod = md5("$email".date('YmdHis'));
		if($cod==$rs->cod||$b->exec("update cliente set cod='$cod' where id=$id limit 1")){
			$link = "{$s->base}esqueci?id=$id&email=$email&cod=$cod";
			$send->subject = "Shark Pro - Redefinição de senha";
			$send->html = '<h1>Redefinição de senha</h1>Clique no link abaixo ou copie e cole na barra de endereço do navegador para redefinir sua senha.<br/><br/><a href="'.$link.'">'.$link.'</a>';
			$send->to = array(array($email,$rs->n));
			if($x->send = $s->send($send)){
				$x->m = "E-mail enviado com sucesso!\n\nVerifique sua caixa de entrada ou sua caixa de spam!";
				$x->ok = 1;
				$x->c = '';
			}else $x->m = 'Erro ao enviar o e-mail!';
		}else $x->m = 'Erro ao salvar os dados para redefinir a senha!';
	}else $x->m = 'Este e-mail não está cadastrado!';
}else $neg = true;

?>