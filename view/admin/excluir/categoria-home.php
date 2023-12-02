<div class="col-md-12">
	<div class="panel panel-white">
		<div class="panel-heading clearfix">
			<h4 class="panel-title">Alterar Categorias da Home</h4>
		</div>
		<div class="panel-body">
			<form id="id-form">
				<div class="form-group col-md-12">
					<label for="idc">* Categoria</label>
					<select class="form-control" name="idc" id="idc"></select>
				</div>
				<div class="form-group col-md-12">
					<label for="i">Imagem:</label>
					<input type="file" name="i" class="txt left mr"/>
					<div class="text left ml"><span><strong>Largura:</strong> 639px</span><span><strong>Altura:</strong> 360px</span></div>
					<div class="clearfix"></div>
					<div id="img-view-i" class="img-view col-sm-6" cls="top"></div>
				</div>
				<div class="form-group col-md-12">
					<label for="idc2">* Categoria 2</label>
					<select class="form-control" name="idc2" id="idc2"></select>
				</div>
				<div class="form-group col-md-12">
					<label for="i2">Imagem 2:</label>
					<input type="file" name="i2" class="txt left mr"/>
					<div class="text left ml"><span><strong>Largura:</strong> 639px</span><span><strong>Altura:</strong> 360px</span></div>
					<div class="clearfix"></div>
					<div id="img-view-i2" class="img-view col-sm-6" cls="top"></div>
				</div>
				<div class="form-group col-md-12">
					<label for="idc3">* Categoria 3</label>
					<select class="form-control" name="idc3" id="idc3"></select>
				</div>
				<div class="form-group col-md-12">
					<label for="i3">Imagem 3:</label>
					<input type="file" name="i3" class="txt left mr"/>
					<div class="text left ml"><span><strong>Largura:</strong> 639px</span><span><strong>Altura:</strong> 360px</span></div>
					<div class="clearfix"></div>
					<div id="img-view-i3" class="img-view col-sm-6" cls="top"></div>
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
	a:'categoria',
	load:function(_,F,f,e,o,i){
		e = f.idc;
		o = e.options;
		$.each(_.cat,function(i,v){
			o[i=o.length] = new Option(v[0],v[1]);
			if(v[1]==_.idc)e.selectedIndex = i;
		});

		e = f.idc2;
		o = e.options;
		$.each(_.cat,function(i,v){
			o[i=o.length] = new Option(v[0],v[1]);
			if(v[1]==_.idc2)e.selectedIndex = i;
		});

		e = f.idc3;
		o = e.options;
		$.each(_.cat,function(i,v){
			o[i=o.length] = new Option(v[0],v[1]);
			if(v[1]==_.idc3)e.selectedIndex = i;
		});
	}
});
</script>
<script type="text/javascript">
$.extend(adm,<?=json_encode($a)?>);
</script>
<?
Inline::b();
?>