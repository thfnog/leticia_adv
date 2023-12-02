<div class="col-md-12">
	<div class="panel panel-white">
		<div class="panel-heading clearfix">
			<h4 class="panel-title"><?=$s->id?'Alterar':'Novo'?> Parceiro</h4>
		</div>
		<div class="panel-body">
			<form id="id-form">
				<div class="form-group col-md-12">
					<label for="n">* Nome</label>
					<input type="text" class="form-control" id="n" name="n" placeholder="Digite o nome do parceiro" value="<?=strh($rs->n)?>">
				</div>
				<div class="form-group col-md-12">
					<label for="l">Link</label>
					<input type="text" class="form-control" id="l" name="l" placeholder="Digite o link do parceiro" value="<?=strh($rs->l)?>">
				</div>
				<div class="clearfix"></div>
				<div class="form-group col-md-12">
					<label for="i">* Imagem:</label>
					<input type="file" name="i" class="txt left mr"/>
					<div class="text left ml"><span><strong>Largura Mínima:</strong> 140px</span><span><strong>Altura Mínima:</strong> 100px</span></div>
					<div class="clearfix"></div>
					<div id="img-view-i" class="img-view col-sm-6" cls="top">
						<label class="top">Remover Imagem:<input type="checkbox" name="ri" value="1" class="ckb"/></label>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="form-group col-md-12">
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
	a:'parceiro',
	load:function(_,F,f,e,o,i){}
});
</script>
<script type="text/javascript">
$.extend(adm,<?=json_encode($a)?>);
</script>
<?
Inline::b();
?>