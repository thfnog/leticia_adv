<?php
$medida = $b->query($sql="select max(p.altura) altura,max(p.comprimento) comprimento,max(p.largura) largura from pedido c left join pedido_ax a on c.id=a.idc left join produto p on a.idp=p.id where c.id=$id")->fetchObject();
$comprimento = $medida->comprimento;
$altura = $medida->altura;
$largura = $medida->largura;
$peso = $rs->w;
$nome = $rs->n;
$rua = $rs->rua;
$cep = $rs->cep;
$num = $rs->num;
$bairro = $rs->bairro;
$comp = $rs->comp;
$city = $rs->city;
$uf = $rs->uf;

$params = include "controller/admin/criar-pre-lista.php";

$phpSigep = new PhpSigep\Services\SoapClient\Real();
$result = $phpSigep->fechaPlpVariosServicos($params);
$result = $result->getResult();

/*echo '<pre>';
print_r((array)$result);
echo '</pre>';*/
?>
<div class="col-md-12">
	<div class="panel panel-white">
		<div class="panel-heading clearfix">
			<h4 class="panel-title">Fechar PLP</h4>
		</div>
		<div class="panel-body">
<?
if($result == null){
	if(!$rs->plp)echo "Ocorreu um erro ao gerar a PLP com os pedidos selecionados.<br />";
	else echo "PLP: ".$rs->plp.'<br>';
	//var_dump($result);
	//exit();
}else{
	$idPLP = $result->getIdPlp();
	echo "PLP: ".$idPLP;
	if($idPLP)$b->query("update pedido set plp='$idPLP',plpFechada=1 where id=$id limit 1");
}
?>
			<br><br>
			<a href="admin/imprimir-etiqueta/<?=$s->id?>" class="btn btn-success" target="_blank"><i class="fa fa-print"></i> IMPRIMIR ETIQUETA</a>
			<a href="admin/imprimir-plp/<?=$s->id?>" class="btn btn-success" target="_blank"><i class="fa fa-print"></i> IMPRIMIR PLP</a>
		</div>
	</div>
</div>