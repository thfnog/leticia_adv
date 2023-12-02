<?
if(true){
	$pg = strpr('pg');
	$n = strpr('n');
	$t1 = strpr('t1');
	$ass = strpr('ass');
	$email = strpr('email',1);
	$msg = strpr('msg');

	if(!$n)$x->m = 'Digite o Nome!';
	elseif(strlen($n)<6)$x->m = 'Digite o nome com minímo de 6 caracteres!';
	elseif(strpos($n,' ')===false)$x->m = 'Digite o nome completo!';
	elseif(!$email)$x->m = 'Digite o E-mail!';
	elseif(!preg_match($emailRE,$email))$x->m = 'E-mail inválido!';
	elseif(!$t1)$x->m = 'Digite um telefone!';
	elseif(!$ass)$x->m = 'Digite um assunto!';
	elseif(!$msg)$x->m = 'Digite a mensagem!';
	else{
		if($pg =='contato'){
			$send->subject = "Contato - Caramelo Foods";
		}else if($pg =='consultoria'){
			$send->subject = "Consultoria - Caramelo Foods";
		}
		$send->html = 
		"<strong>Nome:</strong> ".strh($n)."<br/>
		<strong>E-mail:</strong> ".strh($email)."<br/>
		<strong>Telefone:</strong> ".strh($t1)."<br/>
		<strong>Assunto:</strong> ".strh($ass)."<br/>
		<strong>Mensagem:</strong><div style=\"margin: 0;padding: 10px;border: 1px solid #ddd;\">".strhb($msg)."</div>";
		//$send->from = array($email,$n);
		//$send->to = 1;
		$send->to = array('lucas@alquati.com.br');
		// $send->bcc = array('eduardo@alquati.com.br');
		if($x->send = $s->send($send)){
    	$x->m = 'Mensagem enviada com sucesso!';
  		}else $x->m = "Ocorreu um erro inesperado. Tente novamente. Se o erro persistir, envie sua mensagem para contato@caramelofoods.com.br.";
 	}
}else $neg = true;
?>