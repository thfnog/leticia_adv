<div class="col-md-12">
	<div class="panel panel-white">
		<div class="panel-heading clearfix">
			<h4 class="panel-title">Dados do Revendedor</h4>
		</div>
		<div class="panel-body" style="margin-top:10px">
			<div class="form-group">
<?
$rs->i = $rs->i&&file_exists('upload/revendas/'.$rs->i)?$rs->i:'default.jpg';
if($rs->i){
?>
				<img src="upload/revendas/<?=$rs->i?>" style="max-width:300px"/>
				<div class="clearfix" style="height:20px"></div>
<?
}if($rs->n){
?>
				<strong>Nome / Razão Social: </strong><span><?=$rs->n?></span><br>
<?
}if($rs->tp==1&&$rs->cpf){
?>
				<strong>CPF: </strong><span><?=$rs->cpf?></span><br>
<?
}if($rs->tp==1&&$rs->rg){
?>
				<strong>RG: </strong><span><?=$rs->rg?></span><br>
<?
}if($rs->tp==2&&$rs->cnpj){
?>
				<strong>CNPJ: </strong><span><?=$rs->cnpj?></span><br>
<?
}if($rs->tp==2&&$rs->ie){
?>
				<strong>IE: </strong><span><?=$rs->i?></span><br>
<?
}if($rs->email){
?>
				<strong>E-mail: </strong><span><?=$rs->email?></span><br>
<?
}if($rs->t1){
?>
				<strong>Telefone Fixo: </strong><span><?=$rs->t1?></span><br>
<?
}if($rs->t2){
?>
				<strong>Telefone Celular: </strong><span><?=$rs->t2?></span><br>
<?
}if($rs->rua||$rs->num||$rs->comp||$rs->cep||$rs->bairro||$rs->city||$rs->uf){
?>
				<strong>Endereço: </strong><span><?=($rs->rua?$rs->rua:'').($rs->num?', '.$rs->num:'').($rs->comp?', '.$rs->comp:'').($rs->cep?' - '.$rs->cep:'').($rs->bairro?' '.$rs->bairro:'').($rs->city?' - '.$rs->city:'').($rs->uf?'/'.$rs->uf:'')?></span><br>
<?
}if($rs->msg){
?>
				<strong>Mensagem: </strong><p><?=$rs->msg?></p><br>
<?
}
?>
			</div>
			<div class="clearfix" style="height:40px"></div>
			<a class="btn btn-danger" href="admin/revendedores">Voltar</a>
		</div>
	</div>
</div>