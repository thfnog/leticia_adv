<?php
ini_set('display_errors',1);
ini_set('max_execution_time',300); 
error_reporting(E_ERROR | E_PARSE);//VARS EMAIL
$topo = "{$s->base}assets/img/email/topo.jpg";
$rodape = "{$s->base}assets/img/email/rodape.jpg";
$site = "{$s->base}";
//VARS EMAIL

$rpc = $b->query("select p.n,c.email,p.codEnviado from pedido p inner join cliente c on p.idu=c.id where p.id='$id' limit 1")->fetchObject();
$address_nome = $rpc->n;
$email = $rpc->email;

$send->subject = "Codigo de Rastreio do Pedido n° $id";
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
												<td style="color:#1b1b1b;"> Olá '.strh($address_nome).'!<br>
													<br>
													O código de rastreio do pedido n°: <a href="'.$site.'pedido/'.$id.'"><strong>'.$id.'</strong></a> é <a href="http://www.websro.com.br/detalhes.php?P_COD_UNI='.$c.'" target="_blank">'.$c.'</a> .<br><br>
													Veja atentamente seu pedido e as informações para entrega.<br>
													Qualquer dúvida entre em contato conosco através do e-mail: <a href="mailto:contato@sharkpro.com.br">contato@sharkpro.com.br</a><br><br>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</div>
						<div class="movableContent"> <a href="'.$site.'"><img src="'.$rodape.'" alt="Rodapé" data-default="placeholder" data-max-width="800" width="800"/></a> </div></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td height="55"></td>
	</tr>
</table>
</body>
</html>';
$send->reply = array('contato@sharkpro.com.br');

$send->to = array($email);
$send->bcc = array('rodrigo@alquati.com.br');

if($c!=$rpc->codEnviado){
	if($x->send=$s->send($send))$b->query("update pedido set codEnviado='$c' where id=$id limit 1");
	$x->codigoEmail = $c;
}