<?php
if($s->tipoAdm==2)$s->loc('admin');
$s->lay = 'blank';
set_time_limit(5);

//$accessDataProduction = new \PhpSigep\Model\AccessDataHomologacao();
/*$accessDataProduction = new \PhpSigep\Model\AccessDataProduction();
$usuario = trim($accessDataProduction->getUsuario());
$senha = trim($accessDataProduction->getSenha());
$cnpjEmpresa = $accessDataProduction->getCnpjEmpresa();*/


/*$accessDataEtiquetas = new \PhpSigep\Model\AccessData();
$accessDataEtiquetas->setUsuario($usuario);
$accessDataEtiquetas->setSenha($senha);
$accessDataEtiquetas->setCnpjEmpresa($cnpjEmpresa);*/



$paramsEtiquetas = new \PhpSigep\Model\SolicitaEtiquetas();
$paramsEtiquetas->setQtdEtiquetas(1);
if($forma=='pac')$paramsEtiquetas->setServicoDePostagem(\PhpSigep\Model\ServicoDePostagem::SERVICE_PAC_CONTRATO_AGENCIA);
else $paramsEtiquetas->setServicoDePostagem(\PhpSigep\Model\ServicoDePostagem::SERVICE_SEDEX_CONTRATO_AGENCIA);
//$paramsEtiquetas->setAccessData($accessDataEtiquetas);
$paramsEtiquetas->setAccessData(new \PhpSigep\Model\AccessDataProduction());


$solicitar = new \PhpSigep\Services\SoapClient\Real();

try{
	$solicitado = $solicitar->solicitaEtiquetas($paramsEtiquetas)->getResult();
	/*echo 'params: <br><pre>';
	print_r($paramsEtiquetas);
	echo '</pre>solicitar: <br><pre>';
	var_dump($solicitar->solicitaEtiquetas($paramsEtiquetas));
	echo '</pre>solicitado: <br><pre>';
	print_r($solicitado);
	echo '</pre>';
	exit;*/
	$c = $etiquetaSemDv = $solicitado[0]->getEtiquetaSemDv();
}catch(Exception $error){
	echo 'ERROR: '.print_r($error);
}