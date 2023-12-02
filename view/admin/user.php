<div class="col-md-12">
	<div class="panel panel-white">
		<div class="panel-heading clearfix">
			<h4 class="panel-title"><?=$s->id?'Alterar':'Novo'?> Usuário</h4>
		</div>
		<div class="panel-body">
			<form id="id-form">
				<div class="tab-content">
					<!--<div class="form-group col-md-12">
						<label for="tp">* Tipo de Usuário:</label>
						<select name="t" class="form-control" id="tp"></select>
					</div>-->
					<div class="form-group col-md-12">
						<label for="n">* Nome</label>
						<input type="text" class="form-control" id="n" name="n" placeholder="Digite o nome" value="<?=strh($rs->n)?>">
					</div>
					<div class="form-group col-md-12">
						<label for="email">* E-mail</label>
						<input type="email" class="form-control" id="email" name="email" placeholder="Digite o e-mail" value="<?=strh($rs->email)?>">
					</div>
					<div class="form-group col-md-12">
						<label for="u">* Usuário</label>
						<input type="text" class="form-control" id="u" name="u" placeholder="Digite o usuário" value="<?=strh($rs->u)?>"	>
					</div>
					<div class="form-group col-md-12">
						<label for="p1"><?=$s->id?'':'* '?>Senha</label>
						<input type="password" class="form-control" id="p1" name="p1" placeholder="Digite a senha<?=$s->id?' se quiser alterar':''?>">
					</div>
					<div class="form-group col-md-12">
						<label for="p2"><?=$s->id?'':'* '?>Confirmar Senha</label>
						<input type="password" class="form-control" id="p2" name="p2" placeholder="Digite a confirmação da senha<?=$s->id?' se quiser alterar':''?>">
					</div>
					<div class="form-group col-md-12">
						<label for="s">
							<span style="display:block;float:left;margin-right:5px">Ativo</span>
							<span><input type="checkbox" id="s" name="s" value="1" class="ckb"<?=$rs->s||!$s->id?' checked':''?>></span>
						</label>
					</div>
					<div class="clearfix" style="height:40px"></div>
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
<script src="assets/js/admin/jquery.validate.min.js" type="text/javascript"></script>
<script type="text/javascript">
var adm = $.form({
	a:'user',
	id:"<?=$s->id?>",
	back:'<?=$s->back?>',
	load:function(_,F,f,e,o){
		/*e = f.t;
		o = e.options;
		$.each(_.tipo,function(i,v){
			o[i=o.length] = new Option(v[0],v[1]);
			if(v[1]==_.t)e.selectedIndex = i;
		});*/
	},
	tipo:[['-- Selecione o Tipo de Usuário --',0],['Administrador Geral',1],['Marketing',2],['Faturamento',3]]
});
</script>
<script type="text/javascript">
$.extend(adm,<?=json_encode($a)?>);
</script>
<script type="text/javascript">
$(document).ready(function() {
    var validator = $('#id-form').validate({
        rules: {
			n: {required: true},
			email: {required: true},
			u: {required: true},
			p1:{required: "<?=$s->id?'false':'true'?>"},
			p2:{required: "<?=$s->id?'false':'true'?>"},
        }
    });
});
</script>
<?
Inline::b();
?>