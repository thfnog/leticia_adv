<div class="col-md-12">
	<div class="panel panel-white">
		<div class="panel-heading clearfix">
			<h4 class="panel-title"><?=$s->id?'Alterar':'Novo'?> Peso</h4>
		</div>
		<div class="panel-body">
			<form id="id-form">
				<div class="form-group col-md-12">
					<label for="n">* Título do Peso</label>
					<input type="text" class="form-control" id="n" name="n" placeholder="Digite o título do peso" value="<?=strh($rs->n)?>">
				</div>
				<div class="clearfix"></div>
				<div class="form-group col-md-3 col-xs-12">
					<label for="peso">* Peso (kg) <i class="fa fa-question-circle" data-toggle="tooltip" title="" style="font-size:16px" data-original-title="O peso não pode ser maior que 30kg"></i></label>
					<input type="number" class="form-control" id="peso" name="peso" placeholder="Digite o peso do produto" value="<?=strh($rs->peso)?>"/>
				</div>
				<div class="form-group col-md-3 col-xs-12">
					<label for="largura">* Largura (cm) <i class="fa fa-question-circle" data-toggle="tooltip" title="" style="font-size:16px" data-original-title="A largura não pode ser maior que 105 cm. A soma resultante do comprimento + largura + altura não deve superar a 200 cm"></i></label>
					<input type="number" class="form-control" id="largura" name="largura" placeholder="Digite a largura do produto" value="<?=strh($rs->largura)?>"/>
				</div>
				<div class="form-group col-md-3 col-xs-12">
					<label for="altura">* Altura (cm) <i class="fa fa-question-circle" data-toggle="tooltip" title="" style="font-size:16px" data-original-title="A altura não pode ser maior que 105 cm. A soma resultante do comprimento + largura + altura não deve superar a 200 cm"></i></label>
					<input type="number" class="form-control" id="altura" name="altura" placeholder="Digite a altura do produto" value="<?=strh($rs->altura)?>"/>
				</div>
				<div class="form-group col-md-3 col-xs-12">
					<label for="comprimento">* Comprimento (cm) <i class="fa fa-question-circle" data-toggle="tooltip" title="" style="font-size:16px" data-original-title="O comprimento não pode ser maior que 105 cm. A soma resultante do comprimento + largura + altura não deve superar a 200 cm"></i></label>
					<input type="number" class="form-control" id="comprimento" name="comprimento" placeholder="Digite o comprimento do produto" value="<?=strh($rs->comprimento)?>"/>
				</div>
				<div class="clearfix"></div>
				<div class="form-group col-md-6">
					<label for="s">
						<span style="display:block;float:left;margin-right:5px">Ativo</span>
						<span><input type="checkbox" id="s" name="s" value="1" class="ckb"<?=$rs->s||!$s->id?' checked':''?>></span>
					</label>
				</div>
				<div class="clearfix" style="height:40px"></div>
				<div class="form-group col-md-12">
					<input type="submit" class="btn btn-success"/>
				</div>
			</form>
		</div>
	</div>
</div>
<?
Inline::a();
?>
<script type="text/javascript">
var adm = $.form({
	a:'peso',
	load:function(_,F,f,e,o,i){}
});
</script>
<script type="text/javascript">
$.extend(true,adm,<?=json_encode($a)?>);
</script>
<?
Inline::b();
?>