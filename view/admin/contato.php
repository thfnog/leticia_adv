<style>
.panel-body .mb8{border-bottom:solid 1px #ebebeb;padding-bottom:8px}
</style>
<div class="tabela2 row">
	<div class="panel panel-white" style="background:transparent">
		<div class="panel-body pedido">
			<div class="tabela2 col-lg-12 col-md-12">
				<div class="panel panel-info">
					<div class="panel-heading" style="height:auto"><h3 class="panel-title uppercase">Dados do Cliente</h3></div>
					<div class="panel-body" style="margin-top:15px">
						<div class="uppercase mb8"><strong>Cadastrado em:</strong> <?=$rs->dc?datef($rs->dc,11):''?></div>
						<div class="uppercase mb8"><strong>Nome:</strong> <?=strh($rs->nome)?></div>
						<div class="uppercase mb8"><strong>E-mail:</strong> <?=strh($rs->email)?></div>
						<div class="uppercase mb8"><strong>Telefone:</strong> <?=strh($rs->telefone)?></div>
						<div class="uppercase mb8"><strong>Mensagem:</strong> <?=strh($rs->mensagem)?></div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
<?
$msgs = $b->query("select * from formulario_ax where id_formulario='{$s->id}' order by dc desc");
if($msgs->rowCount()){
?>
	<div class="panel panel-white" style="background:transparent">
		<div class="panel-body pedido">
			<div class="tabela2 col-lg-12 col-md-12">
				<div class="panel panel-info">
					<div class="panel-heading" style="height:auto"><h3 class="panel-title uppercase">Interações</h3></div>
					<div class="panel-body" style="margin-top:15px">
<?
	while($msg=$msgs->fetchObject()){
		$user = $b->query("select * from user where id='{$msg->id_user}' limit 1")->fetchObject();
?>
						<div class="item">
							<strong><i class="fa fa-user"></i> </strong><?=$user->n?>
							<strong style="padding-left:15px"><i class="fa fa-calendar"></i> </strong> <?=datef($msg->dc,11)?>
							<?=$msg->mensagem?>
						</div>
						<hr />
<?
	}
?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?
}
?>
	<div class="panel panel-white" style="background:transparent">
		<div class="panel-body pedido">
			<div class="tabela2 col-lg-12 col-md-12">
				<div class="panel panel-info">
					<div class="panel-heading" style="height:auto"><h3 class="panel-title uppercase">Nova Interação</h3></div>
					<div class="panel-body" style="margin-top:15px">
						<form id="id-form">
							<div class="form-group col-md-12">
								<label class="control-label" for="msg">* Mensagem</label>
								<div>
									<progress style="display:none;margin-bottom:10px;width:100%"></progress>
									<textarea class="summernote" id="msg" name="msg"><?=strh($rs->msg)?></textarea>
								</div>
							</div>
							<div class="clearfix" style="height:20px"></div>
							<div class="form-group col-md-12">
								<input type="submit" class="btn btn-success"/>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?
Inline::a();
?>
<script type="text/javascript">
var adm = $.form({
	a:'contatos',
});
</script>
<script type="text/javascript">
$.extend(adm,<?=json_encode($a)?>);
</script>
<?
echo $s->summernote();
Inline::b();
?>