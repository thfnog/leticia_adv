<?php
if($s->tipoAdm==2)$s->loc('admin');
$s->lay = 'blank';
/**
* Este script cria e retorna uma instância de {@link \PhpSigep\Model\PreListaDePostagem}
*
* Como existe mais de um exemplo que precisa de uma {@link \PhpSigep\Model\PreListaDePostagem}, esse script foi criado
* para compartilhar o código necessário para a criação da {@link \PhpSigep\Model\PreListaDePostagem}.
*/


// ***  DADOS DA ENCOMENDA QUE SERÁ DESPACHADA *** //
$dimensao = new \PhpSigep\Model\Dimensao();
$dimensao->setAltura($altura);
$dimensao->setLargura($largura);
$dimensao->setComprimento($comprimento);
$dimensao->setDiametro(0);
$dimensao->setTipo(\PhpSigep\Model\Dimensao::TIPO_PACOTE_CAIXA);

$destinatario = new \PhpSigep\Model\Destinatario();
$destinatario->setNome($nome);
$destinatario->setLogradouro($rua);
$destinatario->setNumero($num);
$destinatario->setComplemento($comp);

$destino = new \PhpSigep\Model\DestinoNacional();
$destino->setBairro($bairro);
$destino->setCep($cep);
$destino->setCidade($city);
$destino->setUf($uf);

// Estamos criando uma etique falsa, mas em um ambiente real voçê deve usar o método
// {@link \PhpSigep\Services\SoapClient\Real::solicitaEtiquetas() } para gerar o número das etiquetas
if(!$rs->plp){
	//include "controller/admin/solicita-etiquetas.php";
	$paramsEtiquetas = new \PhpSigep\Model\SolicitaEtiquetas();
	$paramsEtiquetas->setQtdEtiquetas(1);
	if($forma=='pac')$paramsEtiquetas->setServicoDePostagem(\PhpSigep\Model\ServicoDePostagem::SERVICE_PAC_CONTRATO_AGENCIA);
	else $paramsEtiquetas->setServicoDePostagem(\PhpSigep\Model\ServicoDePostagem::SERVICE_SEDEX_CONTRATO_AGENCIA);
	//$paramsEtiquetas->setAccessData($accessDataEtiquetas);
	$paramsEtiquetas->setAccessData(new \PhpSigep\Model\AccessDataProduction());
	
	
	$solicitar = new \PhpSigep\Services\SoapClient\Real();
	
	try{
		$solicitado = $solicitar->solicitaEtiquetas($paramsEtiquetas)->getResult();
		$c = $etiquetaSemDv = $solicitado[0]->getEtiquetaSemDv();
	}catch(Exception $error){
		echo 'ERROR: '.print_r($error);
	}
}

$etiqueta = new \PhpSigep\Model\Etiqueta();
//$etiqueta->setEtiquetaSemDv('PD73958096BR');//HOMOLOGAÇÃO
$etiqueta->setEtiquetaSemDv($etiquetaSemDv);//PRODUCTION
$etiquetaComDv = $etiqueta->getEtiquetaComDv();
if($etiquetaComDv){
	$b->query("update pedido set cod='$etiquetaComDv',etiquetaSemDv='$etiquetaSemDv',da=now() where id=$id limit 1");
	$c = $etiquetaComDv;
	//require_once('class/email-codigo.php');
}

$servicoAdicional = new \PhpSigep\Model\ServicoAdicional();
$servicoAdicional->setCodigoServicoAdicional(\PhpSigep\Model\ServicoAdicional::SERVICE_REGISTRO);
// Se não tiver valor declarado informar 0 (zero)
$servicoAdicional->setValorDeclarado(0);

$encomenda = new \PhpSigep\Model\ObjetoPostal();
$encomenda->setServicosAdicionais(array($servicoAdicional));
$encomenda->setDestinatario($destinatario);
$encomenda->setDestino($destino);
$encomenda->setDimensao($dimensao);
$encomenda->setEtiqueta($etiqueta);
$encomenda->setPeso($peso);// 500 gramas
if($forma=='pac')$encomenda->setServicoDePostagem(new \PhpSigep\Model\ServicoDePostagem(\PhpSigep\Model\ServicoDePostagem::SERVICE_PAC_CONTRATO_AGENCIA));
else $encomenda->setServicoDePostagem(new \PhpSigep\Model\ServicoDePostagem(\PhpSigep\Model\ServicoDePostagem::SERVICE_SEDEX_CONTRATO_AGENCIA));
// ***  FIM DOS DADOS DA ENCOMENDA QUE SERÁ DESPACHADA *** //

// *** DADOS DO REMETENTE *** //
$remetente = new \PhpSigep\Model\Remetente();
$remetente->setNome('Shark Pro');
$remetente->setLogradouro('Av. Brigadeiro Faria Lima');
$remetente->setNumero('2152');
$remetente->setComplemento('9 AB');
$remetente->setBairro('Itaim');
$remetente->setCep('04538-132');
$remetente->setUf('SP');
$remetente->setCidade('São Paulo');
// *** FIM DOS DADOS DO REMETENTE *** //


$plp = new \PhpSigep\Model\PreListaDePostagem();
//$plp->setAccessData(new \PhpSigep\Model\AccessDataHomologacao());//HOMOLOGAÇÃO
$plp->setAccessData(new \PhpSigep\Model\AccessDataProduction());//PRODUCTION
$plp->setEncomendas(array($encomenda));
$plp->setRemetente($remetente);

return $plp;
