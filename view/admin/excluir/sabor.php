<div class="col-md-12">
	<div class="panel panel-white">
		<div class="panel-heading clearfix">
			<h4 class="panel-title"><?=$s->id?'Alterar':'Novo'?> Sabor</h4>
		</div>
		<div class="panel-body">
			<form id="id-form">
				<div class="form-group col-md-12">
					<label for="n">* Sabor</label>
					<input type="text" class="form-control" id="n" name="n" placeholder="Digite o sabor" value="<?=strh($rs->n)?>">
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
	a:'sabor',
	load:function(_,F,f,e,o,i){}
});
</script>
<script type="text/javascript">
$.extend(true,adm,<?=json_encode($a)?>);
</script>
<?
Inline::b();
?>