<?
//VARS EMAIL
$topo = "{$s->base}assets/img/email/topo.jpg";
$rodape = "{$s->base}assets/img/email/rodape.jpg";
$site = "{$s->base}";
$base_frete = "{$s->base}assets/img/frete/";
$base_pagamento = "{$s->base}assets/img/pagamentos/";
//VARS EMAIL

$rpc = $b->query("select v,f,t,tf,forma,vd from pedido where id=$id limit 1")->fetchObject();
$rpc->envio = $rpc->tf==1?'pac':'sedex';
$total_fim = '
	<tfoot style="font-size:13px">
		<tr style="padding:0;height:36px">
			<td colspan="2"></td>
			'.($rpc->tf==5?'<td colspan="2" style="text-align:center;background:#211d1e"><strong>FRETE GRÁTIS</strong></td>
			<td colspan="2" style="text-align:center;background:#211d1e;color:#fff"><strong>R$ '.nreal(0).'</strong></td>':'<td colspan="2" style="text-align:center;background:#211d1e"><strong><img src="'.$base_frete.($tipo==5?'frete-gratis':$rpc->envio).'-small.jpg"/></strong></td>
			<td colspan="2" style="text-align:center;background:#211d1e;color:#fff"><strong>R$ '.nreal($rpc->f).'</strong></td>').'
		</tr>
		'.($rpc->vd>0?'<tr>
			<td colspan="2"></td>
			<td colspan="2" style="text-align:center;background:#211d1e;color:#fff"><strong>Desconto</strong></td>
			<td colspan="2" style="text-align:center;color:#f00;background:#211d1e;color:#fff"><strong>R$ '.nreal($rpc->vd).'</strong></td>
		</tr>':'').'
		<tr>
			<td colspan="2"></td>
			<td colspan="2" style="text-align:center;background:#211d1e;color:#fff"><strong>Total do Pedido</strong></td>
			<td colspan="2" style="text-align:center;color:#f00;background:#211d1e;color:#fff"><strong>R$ '.nreal($rpc->t).'</strong></td>
		</tr>
	</tfoot>';
$send->subject = "Confirmação do Pedido n° $id";
$send->html = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>[SUBJECT]</title>
<style type="text/css">
body {padding: 0 !important;margin: 0 !important;width: 100% !important;-webkit-text-size-adjust: 100% !important;-ms-text-size-adjust: 100% !important;-webkit-font-smoothing: antialiased !important;font-family: Verdana}
.tableContent img {border: 0 !important;outline: none !important}
a {color: #382F2E}
p, h1, div, p, ul, h1 {margin: 0}
.bigger {font-size: 24px}
.bgBody {background: #ffffff}
.bgItem {background: #211d1e}
h2 {font-size: 13px;color: #fff;margin: 0;font-weight: normal}
.produtos-email h2 {color: #1b1b1b}
p {font-size: 13px;line-height: 19px;font-weight: normal}
a.link2 {padding: 10px 20px;border-radius: 3px;-moz-border-radius: 3px;-webkit-border-radius: 3px;color: #ffffff;font-size: 13px;background: #fff;text-decoration: none}
a.link1 {font-weight: bold;color: #1b1b1b;font-size: 13px}
</style>
</head>
<body paddingwidth="0" paddingheight="0"  style="padding:0; background-repeat: repeat; width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased;" offset="0" toppadding="0" leftpadding="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableContent bgBody" align="center" style="font-family:Verdana;color:#1b1b1b">
	<tr>
		<td><table width="800" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#fff">
				<tr>
					<td valign="top" class="movableContentContainer"><div class="movableContent">
							<table width="700" border="0" cellspacing="0" cellpadding="0"  align="center" style="background:#211d1e">
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
							<table width="100%" border="0" cellspacing="0" cellpadding="0"  align="center">
								<tr>
									<td height="10"></td>
								</tr>
								<tr>
									<td valign="top"><table border="0" cellspacing="0" cellpadding="0" align="center" width="760">
											<tr>
												<td height="25" colspan="3"></td>
											</tr>
											<tr>
												<td style="color:#1b1b1b;"> Olá '.strh($address->nome).'!<br>
													<br>
													Recebemos seu pedido com sucesso!<br>
													O número do seu pedido é: <a href="'.$site.'pedido/'.$id.'"><strong>'.$id.'</strong></a>.<br>
													<br>
													Veja atentamente seu pedido e as informações para entrega.<br>
													Qualquer dúvida entre em contato conosco através do e-mail: <a href="mailto:contato@sharkpro.com.br">contato@sharkpro.com.br</a></td>
											</tr>
										</table></td>
								</tr>
							</table>
						</div>
						<div class="movableContent" style="margin-top:20px">
							<h3 style="text-align:left;color:#1b1b1b;margin:0;margin-left:25px">Dados do Pedido:</h3>
							<table width="760" border="0" cellspacing="5" cellpadding="10"  align="center">
								<thead>
									<tr style="text-align:center;color:#fff;text-transform:uppercase;font-size:13px;padding:0;height:36px">
										<td></td>
										<td bgcolor="#1b1b1b"><strong>Produto</strong></td>
										<td bgcolor="#1b1b1b" style="width:50px"><strong>Qtde</strong></td>
										<td bgcolor="#1b1b1b" style="width:80px"><strong>Unit</strong></td>
										<td bgcolor="#1b1b1b" style="width:80px"><strong>Total</strong></td>
									</tr>
								</thead>
								'.$produtosEmail.'
								<tr>
									<td height="10"></td>
								</tr>
								'.$total_fim.'
							</table>
						</div>
						<div class="movableContent" style="margin-top:20px">
							<h3 style="text-align:left;color:#1b1b1b;margin:0;margin-left:25px">Dados do Pagamento:</h3>
							<table width="760" border="0" cellspacing="5" cellpadding="10" align="center">
								<thead>
									<tr style="text-align:center;color:#fff;text-transform:uppercase;font-size:13px;padding:0;height:36px">
										<td bgcolor="#1b1b1b" style="width:150px"><strong>Forma de Pagamento</strong></td>
										<td bgcolor="#1b1b1b" style="width:300px"><strong>Confirmação</strong></td>
										<td bgcolor="#1b1b1b" style="width:150px"><strong>Total</strong></td>
									</tr>
								</thead>
								<tr>
									<td width="95" valign="middle" style="background:#211d1e;width:250px"><table>
											<tr>
												<td><a href="'.$link.'"><img src="'.$base_pagamento.($rpc->forma).'.jpg" style="margin:0 auto" data-max-width="200" width="200"></a></td>
											</tr>
										</table></td>
									<td valign="middle" style="background:#211d1e;padding:10px;text-align:center"><div class="contentEditableContainer contentTextEditable">
											<div class="contentEditable">
												<h2>O Pedido só será enviado após o pagamento ser confirmado e compensado.</h2>
											</div>
										</div></td>
									<td valign="middle" style="background:#211d1e;padding:10px;text-align:center"><div class="contentEditableContainer contentTextEditable">
											<div class="contentEditable">
												<h2 style="color:#f00">R$ '.nreal($rpc->t).'</h2>
											</div>
										</div></td>
								</tr>
								<tr>
									<td height="10"></td>
								</tr>
								<tfoot style="font-size:13px">
									<tr>
										<td colspan="1"></td>
										<td bgcolor="#1b1b1b" colspan="2" style="text-align:center;padding:0;height:36px"><a href="mailto:contato@sharkpro.com.br" style="color:#fff;text-transform:uppercase;display:block"><strong>Confirmar o Pagamento</strong></a></td>
									</tr>
								</tfoot>
							</table>
						</div>
						<div class="movableContent" style="margin-top:20px">
							<h3 style="text-align:left;color:#1b1b1b;margin:0;margin-left:25px">Dados da Entrega:</h3>
							<table width="760" border="0" cellspacing="5" cellpadding="10"  align="center">
								<thead>
									<tr style="text-align:center;color:#fff;text-transform:uppercase;font-size:13px;padding:0;height:36px">
										<td bgcolor="#1b1b1b" style="width:140px"><strong>Destinatário</strong></td>
										<td bgcolor="#1b1b1b" style="width:180px"><strong>Endereço</strong></td>
										<td bgcolor="#1b1b1b" style="width:80px"><strong>Comp</strong></td>
										<td bgcolor="#1b1b1b"><strong>Bairro</strong></td>
										<td bgcolor="#1b1b1b" style="width:120px"><strong>Cidade</strong></td>
										<td bgcolor="#1b1b1b" style="width:80px"><strong>CEP</strong></td>
									</tr>
								</thead>
								<tr>
									<td valign="middle" align="center" style="background:#211d1e;"><h2>'.strh($address->nome).'</h2></td>
									<td valign="middle" align="center" style="background:#211d1e;"><h2>'.strh($address->rua).', '.strh($address->num).'</h2></td>
									<td valign="middle" align="center" style="background:#211d1e;"><h2>'.($address->comp?strh($address->comp):'-').'</h2></td>
									<td valign="middle" align="center" style="background:#211d1e;"><h2>'.strh($address->bairro).'</h2></td>
									<td valign="middle" align="center" style="background:#211d1e;"><h2>'.strh($address->city).' - '.strh($address->uf).'</h2></td>
									<td valign="middle" align="center" style="background:#211d1e;"><h2>'.strh($address->cep).'</h2></td>
								</tr>
							</table>
						</div>
						<div class="movableContent" style="margin:20px 0">
							<h3 style="text-align:left;color:#1b1b1b;margin:0;margin-left:25px">Dados Pessoais:</h3>
							<table width="760" border="0" cellspacing="5" cellpadding="10"  align="center">
								<thead>
									<tr style="text-align:center;color:#fff;text-transform:uppercase;font-size:13px;padding:0;height:36px">
										<td bgcolor="#1b1b1b" style="width:140px"><strong>'.$address->nome_razao.'</strong></td>
										<td bgcolor="#1b1b1b" style="width:140px"><strong>'.$address->tipo_cpf_cnpj.'</strong></td>
										<td bgcolor="#1b1b1b" style="width:110px"><strong>Telefone</strong></td>
										<td bgcolor="#1b1b1b" style="width:120px"><strong>E-mail</strong></td>
									</tr>
								</thead>
								<tr>
									<td valign="middle" align="center" style="background:#211d1e;"><h2>'.strh($address->nome).'</h2></td>
									<td valign="middle" align="center" style="background:#211d1e;"><h2>'.strh($address->cpf_cnpj).'</h2></td>
									<td valign="middle" align="center" style="background:#211d1e;"><h2>'.strh($address->tel).'</h2></td>
									<td valign="middle" align="center" style="background:#211d1e;"><h2><a href="mailto:'.strh($address->email).'" style="color:#fff">'.strh($address->email).'</a></h2></td>
								</tr>
							</table>
						</div>
						<div class="movableContent"> <a href="'.$site.'"><img src="'.$rodape.'" alt="Rodapé" data-default="placeholder" data-max-width="800" width="800"/></a> </div></td>
				</tr>
			</table></td>
	</tr>
	<tr>
		<td height="55"></td>
	</tr>
</table>
</body>
</html>';
//$send->reply = array('contato@sharkpro.com.br');
$send->to = array('danilo@sharkpro.com.br','sac@sharkpro.com.br','shark.pro1@outlook.com');
$send->bcc = array('rodrigo@alquati.com.br');
if($x->send=$s->send($send))$b->query("update pedido set enviado=1 where id=$id limit 1");
$s->envio = $_SESSION['envio'] = '';
$s->pagamento = $_SESSION['pagamento'] = '';
?>