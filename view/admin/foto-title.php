<div class="col-md-12">
	<div class="panel panel-white">
		<div class="panel-heading clearfix">
			<h4 class="panel-title"><?=$s->id?'Alterar':'Novo'?> Imagem</h4>
		</div>
		<div class="panel-body">
			<form id="id-form">
				<div class="form-group col-md-6 col-xs-12">
					<label for="title">* Título da Imagem</label>
					<input type="text" class="form-control" id="title" name="title" placeholder="Digite o título da imagem" value="<?=strh($rs->title)?>">
				</div>
				<div class="form-group col-md-6 col-xs-12">
					<label for="alt">* Alt da Imagem</label>
					<input type="text" class="form-control" id="alt" name="alt" placeholder="Digite o alt da imagem" value="<?=strh($rs->alt)?>">
				</div>
				<img class="foto" style="display:none;max-width:300px"/>
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
<link href="assets/css/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="assets/js/admin/select2.min.js"></script>
<script type="text/javascript">
var adm = $.form({
	a:'foto-title',
	load:function(_,F,f,e,o,i){
	},
});
</script>
<script type="text/javascript">
$.extend(adm,<?=json_encode($a)?>);
$(document).ready(function(){
	var img = location.search;
	var img = img.substring(1,img.length);
	$('img.foto').show().attr('src',img);
});
</script>
<?
Inline::b();
?>