<div class="col-md-12">
	<div class="panel panel-white">
		<div class="panel-heading clearfix">
			<h4 class="panel-title">Alterar <?=$rs->n?></h4>
		</div>
		<div class="panel-body">
			<form id="id-form">
				<h3 class="panel-title">FRETE</h3>
				<div class="form-group col-md-12">
					<label for="vf">* Valor Mínimo para Frete Grátis:</label>
					<input type="number" step="0.10" class="form-control" id="vf" name="vf" placeholder="Digite o valor mínimo para frete grátis" value="<?=strh($rs->vf)?>"/>
				</div>
				<div class="form-group col-md-12">
					<label for="frete">
						<span style="display:block;float:left;margin-right:5px">Ativar Frete Grátis</span>
						<span><input type="checkbox" id="frete" name="frete" value="1" class="ckb"<?=$rs->frete||!$s->id?' checked':''?>></span>
					</label>
				</div>
				<h3 class="panel-title">BOLETO</h3>
				<div class="form-group col-md-12">
					<label for="vb">* Taxa do Boleto:</label>
					<input type="number" step="0.10" min="0" class="form-control" id="vb" name="vb" placeholder="Digite a taxa do boleto" value="<?=strh($rs->vb)?>"/>
				</div>
				<div class="form-group col-md-12">
					<label for="vd">* Valor de Desconto do Boleto:</label>
					<input type="number" step="1" class="form-control" id="vd" name="vd" placeholder="Digite o valor de desconto do boleto" value="<?=strh($rs->vd)?>"/>
				</div>
				<div class="form-group col-md-12">
					<label for="desconto">
						<span style="display:block;float:left;margin-right:5px">Ativar Desconto no Boleto</span>
						<span><input type="checkbox" id="desconto" name="desconto" value="1" class="ckb"<?=$rs->desconto||!$s->id?' checked':''?>></span>
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
	a:'informacoes',
	load:function(_,F,f,e,o,i){}
});
</script>
<script type="text/javascript">
$.extend(adm,<?=json_encode($a)?>);
</script>
<?
Inline::b();
?>