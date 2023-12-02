<div class="col-md-12">
	<div class="panel panel-white">
		<div class="panel-heading clearfix">
			<h4 class="panel-title"><?=$s->id?'Alterar':'Novo'?> E-mail</h4>
		</div>
		<div class="panel-body">
			<form id="id-form">
				<div class="form-group col-md-12">
					<label for="idg">* Grupo</label>
					<select class="form-control" id="idg" name="idg"></select>
				</div>
				<div class="form-group col-md-12" style="display:none">
					<label for="n">Nome</label>
					<input type="text" class="form-control" id="n" name="n" placeholder="Digite o nome" value="<?=strh($rs->n)?>">
				</div>
				<div class="form-group col-md-12">
					<label for="email">* E-mail</label>
					<input type="email" class="form-control" id="email" name="email" placeholder="Digite o e-mail" value="<?=strh($rs->email)?>">
				</div>
				<div class="clearfix"></div>
				<div class="form-group col-md-12">
					<label for="s">Receber E-mail</label>
					<span><input type="checkbox" id="s" name="s" value="1" class="ckb"<?=$rs->s||!$s->id?' checked="checked"':''?>></span>
				</div>
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
	a:'email',
	id:"<?=$s->id?>",
	back:'<?=$s->back?>',
	load:function(_,F,f,e,o,i){
		e = f.idg;
		o = e.options;
		$.each(_.gru,function(i,v){
			o[i=o.length] = new Option(v[0],v[1]);
			if(v[1]==_.idg)e.selectedIndex = i;
		});
	}
});
</script>
<script type="text/javascript">
$.extend(adm,<?=json_encode($a)?>);
</script>
<script type="text/javascript" src="assets/js/admin/jquery.validate.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    var validator = $('#id-form').validate({
        rules: {
			idg: {
				valueNotEquals: 0,
				required: true
			},
            n: {
                required: true
            }
        }
    });
});
</script>
<?
Inline::b();
?>