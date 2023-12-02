<?
//ini_set('display_errors',1);
//error_reporting(E_ALL^E_NOTICE);
if(true){
	$id = 0;
	$ip = $s->ip;
	$cnpj = strps('cnpj');
	$r = strps('r');
	$nf = strps('nf');

	$n = strpr('nome');
	$email = strpr('email',1);
	$t1 = strpr('t1');

	$cep = strps('cep');
	$cep = str_replace('.','',$cep);
	$rua = strps('rua');
	$num = strps('num');
	$comp = strps('comp');
	$bairro = strps('bairro');
	$city = strps('city');
	$uf = strps('uf');

	$campo = strp('campo',3);

	$recaptchaResponse = strpr('g-recaptcha-response');
	$secretKey = '6LeDYk4UAAAAAFzqnvPMuiG2AqvU5nFJDTU3PTTc';
	if($recaptchaResponse){
		$x->url = $url = "https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$recaptchaResponse;
		$x->request = $request = json_decode(file_get_contents($url));
	}

	$topo = "{$s->base}assets/img/email/topo.jpg";
	$rodape = "{$s->base}assets/img/email/rodape.jpg";
	$site = "{$s->base}";

	if($_cnpj=preg_match($cnpjRE,$cnpj,$_m))$cnpj = "{$_m[1]}.{$_m[2]}.{$_m[3]}/{$_m[4]}-{$_m[5]}";
	if($_cep=preg_match($cepRE,$cep,$_m))$cep = "{$_m[1]}-{$_m[2]}";

	if(!$cnpj)$x->m = 'Digite o CNPJ!';
	elseif(!$_cnpj||!$s->validar->cnpj($cnpj))$x->m = 'CNPJ inválido';
	elseif(!$r)$x->m = 'Digite a Razão Social!';
	elseif(!$nf)$x->m = 'Digite o Nome Fantasia!';
	elseif(!$n)$x->m = 'Digite o Nome!';
	elseif(!$email)$x->m = 'Digite o E-mail!';
	elseif(!preg_match($emailRE,$email))$x->m = 'E-mail inválido!';
	elseif(!$t1||$t1=='(__) ____-_____')$x->m = 'Digite o telefone!';
	elseif(!$cep)$x->m = 'Digite o CEP!';
	elseif(!$_cep)$x->m = 'CEP inválido!';
	elseif(!$rua)$x->m = 'Digite o logradouro';
	elseif(!$num)$x->m = 'Digite o número!';
	elseif(!$bairro)$x->m = 'Digite o bairro!';
	elseif(!$city)$x->m = 'Digite a cidade!';
	elseif(!$uf)$x->m = 'Selecione o estado!';
	elseif(!$campo)$x->m = 'Selecione o campo de interesse!';
	elseif($campo>3)$x->m = 'Campo de interesse inválido!';
	else{
		$campos = array('','Canal Bodyshop','Canal Farma','Ambos');
		$campoNome = $campos[$campo];
		$send->subject = 'Cadastro Representante Shark Pro';
		//$send->debug = 5;
		/*$send->html = '
		<strong>Nome:</strong> '.strh($n).'<br/>
		<strong>E-mail:</strong> '.strh($email).'<br/>
		'.($t1?'<strong>Telefone:</strong> '.strh($t1).'<br/>':'').'
		<strong>Proposta:</strong><div style="color:#d00b0b;margin: 0;padding: 10px">'.strhb($Proposta).'</div>';*/
		$send->html = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
body {padding: 0 !important;margin: 0 !important;width: 100% !important;-webkit-text-size-adjust: 100% !important;-ms-text-size-adjust: 100% !important;-webkit-font-smoothing: antialiased !important;font-family: Verdana}
.tableContent img {border: 0 !important;outline: none !important}
a {color: #382F2E}
p, h1, div, p, ul, h1 {margin: 0}
.bigger {font-size: 24px}
.bgBody {background: #ffffff}
.bgItem {background: #afe3f9}
h2 {font-size: 13px;color: #211d1e;margin: 0;font-weight: normal}
p {font-size: 13px;line-height: 19px;font-weight: normal}
a.link2 {padding: 10px 20px;border-radius: 3px;-moz-border-radius: 3px;-webkit-border-radius: 3px;color: #ffffff;font-size: 13px;background: #fff;text-decoration: none}
a.link1 {font-weight: bold;color: #211d1e;font-size: 13px}
</style>
</head>
<body paddingwidth="0" paddingheight="0"  style="padding:0; background-repeat: repeat; width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased;" offset="0" toppadding="0" leftpadding="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableContent bgBody" align="center" style="font-family:Verdana;color:#211d1e">
	<tr>
		<td><table width="800" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#fff">
				<tr>
					<td valign="top" class="movableContentContainer"><div class="movableContent">
							<table width="700" border="0" cellspacing="0" cellpadding="0"  align="center" style="background:#afe3f9">
								<tr>
									<td></td>
								</tr>
							</table>
						</div>
						<div class="movableContent">
							<table width="800" border="0" cellspacing="0" cellpadding="0"  align="center">
								<tr>
									<td><div class="contentEditableContainer contentImageEditable">
											<div class="contentEditable"><a href="'.$site.'"><img src="'.$topo.'" alt="Topo" data-default="placeholder" data-max-width="800" width="800"/></a></div>
										</div></td>
								</tr>
							</table>
						</div>
						<div class="movableContent">
							<table width="800" border="0" cellspacing="0" cellpadding="0"  align="center">
								<tr><td height="10"></td></tr>
								<tr>
									<td valign="top" bgcolor="#f5f7f8"><table border="0" cellspacing="0" cellpadding="0"  align="center">
											<tr><td height="25" colspan="3"></td></tr>
											<tr>
												<td width="25"></td>
												<td>
													<table border="0" cellspacing="0" cellpadding="0"  align="center">
														<tr>
															<td>
																<table border="0" cellspacing="0" cellpadding="0"  align="center">
																	<tr>
																		<td width="225"><hr style="border:2px solid #211d1e;"/></td>
																		<td width="300" style="padding:0 10px;"><div class="contentEditableContainer contentTextEditable">
																				<div class="contentEditable" style="color:#211d1e;font-size:26px;font-weight:normal;font-family:arial;text-align:center;">
																					<h1 class="bigger" style="font-size:24px">Seja um Representante</h1>
																				</div>
																			</div></td>
																		<td width="225"><hr style="border:2px solid #f58634;"/></td>
																	</tr>
																</table>
															</td>
														</tr>
														<tr><td height="25"></td></tr>
														<tr>
															<td>
																<div class="contentEditableContainer contentTextEditable">
																	<div class="contentEditable" >
																		<p style="color:#211d1e;font-size:13px;line-height:19px;font-family:arial;font-weight:normal;">
																			<strong>CNPJ:</strong> '.strh($cnpj).'<br/>
																			<strong>Razão Social:</strong> '.strh($r).'<br/>
																			<strong>Nome Fantasia:</strong> '.strh($nf).'<br/>
																			<strong>Nome:</strong> '.strh($n).'<br/>
																			<strong>E-mail:</strong> '.strh($email).'<br/>
																			<strong>Telefone:</strong> '.strh($t1).'<br/>
																			<strong>Endereço:</strong> '.strh($rua.', '.$num.	' - '.$bairro.' - '.$city.'/'.$uf.' - '.$cep).'<br/>
																			<strong>Campo de Interesse:</strong> '.strh($campoNome).'
																		</p>
																	</div>
																</div>
															</td>
														</tr>
													</table>
												</td>
												<td width="25"></td>
											</tr>
											<tr><td height="35" colspan="3"></td></tr>
										</table>
									</td>
								</tr>
							</table>
						</div>
						<div class="movableContent">
							<a href="'.$site.'"><img src="'.$rodape.'" alt="Rodapé" data-default="placeholder" data-max-width="800" width="800"/></a>
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td height="55"></td></tr>
</table>
</body>
</html>';
			
		//$send->secure = 'ssl';
		//$send->debug = true;
		$send->reply = array($email);
		if($campo==1)$send->to = array('rafael.vieira@sharkpro.com.br');
		elseif($campo==2)$send->to = array('rodrigo.gomes@sharkpro.com.br');
		else $send->to = array('rafael.vieira@sharkpro.com.br','rodrigo.gomes@sharkpro.com.br');
		$send->cc = array('danilo@sharkpro.com.br','sac@sharkpro.com.br','shark.pro1@outlook.com');
		$send->bcc = array('rodrigo@alquati.com.br');
		if($x->send=$s->send($send)){
			$x->ok = 1;
			$x->m = 'Cadastro realizado com sucesso!';
			$b->query("insert into representante set dc=now(),enviado='Sim',cnpj='$cnpj',r='$r',nf='$nf',nome='$n',email='$email',t1='$t1',cep='$cep',rua='$rua',num='$num',comp='$comp',bairro='$bairro',city='$city',uf='$uf',campo='$campoNome'");
			$x->l = 'obrigado-contato';
		}else{
			$b->query("insert into representante set dc=now(),enviado='Não',cnpj='$cnpj',r='$r',nf='$nf',nome='$n',email='$email',t1='$t1',cep='$cep',rua='$rua',num='$num',comp='$comp',bairro='$bairro',city='$city',uf='$uf',campo='$campoNome'");
			$x->m = "Ocorreu um erro inesperado. Tente novamente. Se o erro persistir, envie sua mensagem para {$send->to[0]->mail}.";
		}
	}
}else $neg = true;
?>