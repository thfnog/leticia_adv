<?
if(true){
	//https://github.com/gabrielrcouto/php-itaucripto
	$id = strp('id',3);
	if(!$s->cli())$s->loc('login');
	$ped = $b->query("select p.n,p.cep,p.rua,p.num,p.bairro,p.comp,p.city,p.uf,p.t v,p.via_boleto via,c.tp,c.cpf,c.cnpj from pedido p left join cliente c on p.idu=c.id where p.id=$id and c.id={$s->idc} and p.forma='boleto' limit 1")->fetchObject();
	if(!$ped)$s->loc('pedidos');
	
	$n = $ped->n;
	$cep = $ped->cep;
	$cep = str_replace(".","",$cep);
	$cep = str_replace("-","",$cep);
	$rua = $ped->rua;
	$num = $ped->num;
	$comp = $ped->comp;
	$bairro = $ped->bairro;
	$city = $ped->city;
	$uf = $ped->uf;
	if($_cpf=preg_match($cpfRE,$ped->cpf,$_m))$cpf = "{$_m[1]}{$_m[2]}{$_m[3]}{$_m[4]}";
	if($_cnpj=preg_match($cnpjRE,$ped->cnpj,$_m))$cnpj = "{$_m[1]}{$_m[2]}{$_m[3]}{$_m[4]}{$_m[5]}";
	$cpf_cnpj = $ped->tp==1?$cpf:$cnpj;
	$tipo_cpf_cnpj = $ped->tp==1?"01":"02";
	//$total = $ped->v - $ped->vb;
	$total = $ped->v;
	$total_boleto = nreal($total);
	$total_boleto = str_replace(".","",$total_boleto);
	
	$ped->via = $ped->via==9?0:$ped->via;
	$via = $ped->via + 1;

	include 'class/ItauLibrary/itaucripto.php';
	$cripto = new Itaucripto;
	
	//Preencha as variáveis abaixo com os dados do cliente e da cobrança
	//Abaixo é só um exemplo!
	$codEmp = "J0028442380001290000028552";//CÓDIGO DO SITE
	$pedido = $via."0".$id;//ID DO PEDIDO
	$valor = $total_boleto;//VALOR DO PEDIDO USAR VÍRGULA COMO SEPARADOR DE CASAS
	$observacao = "";//OBS
	$chave = "S1m2k3t4w5s6p7o8";//CHAVE
	$nomeSacado = $n;
	$codigoInscricao = $tipo_cpf_cnpj;//CÓDIGO DO SACADO 01-CPF/02-CNPJ
	$numeroInscricao = $cpf_cnpj;//CPF OU CNPJ
	$enderecoSacado = $rua.", ".$num;
	$bairroSacado = $bairro;
	$cepSacado = $cep;
	$cidadeSacado = $city;
	$estadoSacado = $uf;
	$dataVencimento = date("dmY",strtotime("+1 day"));
	//$url = "{$s->base}";
	$url = "{$_SERVER['HTTP_HOST']}{$s->dir}";
	$urlRetorna = $url."pedido/".$id;
	$obsAd1 = "";
	$obsAd2 = "";
	$obsAd3 = "";

	$dados = $cripto->geraDados($codEmp,$pedido,$valor,$observacao,$chave,$nomeSacado,$codigoInscricao,$numeroInscricao,$enderecoSacado,$bairroSacado,$cepSacado,$cidadeSacado,$estadoSacado,$dataVencimento,$urlRetorna,$obsAd1,$obsAd2,$obsAd3);
	$b->query("update pedido set via_boleto=$via where id=$id limit 1");
	$x->ok = 1;
	$x->boleto = 1;
	$x->pedido = $pedido;
	$x->data = $dataVencimento;
	$x->valor = $valor;
	$x->dados = $dados;
}else $neg = true;
?>