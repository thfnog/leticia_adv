<div class="form-group col-md-12" style="overflow:overlay">
	<form id="id-form">
		<img src="upload/<?=$pasta.'/'.$rs->i?>" id="cropbox"/>
		<input type="hidden" name="x"/>
		<input type="hidden" name="y"/>
		<input type="hidden" name="w"/>
		<input type="hidden" name="h"/><br/><br/>
		<input type="submit" class="btn btn-success"/><br/><br/>
		<h3>* Se a imagem for maior que a sua resolução, use a barra de rolagem abaixo para visuzalizar a imagem completa.</h3><br/><br/>
		<input type="hidden" name="tabela" value="<?=$tabela?>"/>
		<input type="hidden" name="largura" value="<?=$largura?>"/>
		<input type="hidden" name="altura" value="<?=$altura?>"/>
		<input type="hidden" name="pasta" value="<?=$pasta?>"/>
		<input type="hidden" name="subpasta" value="<?=$subpasta?>"/>
		<input type="hidden" name="img" value="<?=$img?>"/>
		<input type="hidden" name="thumb" value="<?=$thumb?>"/>
	</form>
</div>
<?
Inline::a();
?>
<link href="assets/css/jquery.jcrop.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="assets/js/admin/jquery.jcrop.js"></script>
<script type="text/javascript">
var adm = $.form({
	a:'crop',
	sub:'Recortar Imagem',
	load:function(_,F,f,e,o){
		$('#cropbox').Jcrop({
			//setSelect:[<?=$largura?>,<?=$altura?>,0,0],
			setSelect:[<?=$largura*100?>,<?=$altura*100?>,0,0],
			aspectRatio:<?=$largura?>/<?=$altura?>,
			onSelect:function(c){
				$(f.x).val(c.x);
				$(f.y).val(c.y);
				$(f.w).val(c.w);
				$(f.h).val(c.h);
			},
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