<div class="col-md-12">
	<div class="panel panel-white">
		<div class="panel-heading clearfix">
			<h4 class="panel-title"><?=$s->id?'Alterar':'Novo'?> Objetivo</h4>
		</div>
		<div class="panel-body">
			<div id="rootwizard">
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#tab1" data-toggle="tab"><i class="fa fa-user m-r-xs"></i>Geral</a></li>
<?
$sfotos = $b->query("select * from fotos where idp='{$s->id}' and tipo='objetivo'");
if($s->id){
?>
					<li role="presentation"><a href="#tab2" data-toggle="tab"><i class="fa fa-image m-r-xs"></i>Imagens</a></li>
<?
}
?>
					<li role="presentation"><a href="#tab3" data-toggle="tab"><i class="fa fa-cog m-r-xs"></i>Produtos</a></li>
					<li role="presentation"><a href="#tab4" data-toggle="tab"><i class="fa fa-google m-r-xs"></i>SEO</a></li>
				</ul>
				<div class="progress progress-sm m-t-sm">
					<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
					</div>
				</div>
				<form id="id-form">
					<div class="tab-content">
						<div class="tab-pane active fade in" id="tab1">
							<div class="form-group col-md-12">
								<label for="h1">* Título (H1)</label>
								<input type="text" class="form-control" id="h1" name="h1" placeholder="Digite o título (h1)" value="<?=strh($rs->h1)?>">
							</div>
							<div class="form-group col-md-12">
								<label for="n">* Slug (usado para url do objetivo)</label>
								<input type="text" class="form-control" id="n" name="n" placeholder="Digite o slug (usado para url do objetivo)" value="<?=strh($rs->n)?>">
							</div>
							<div class="form-group col-md-12">
								<label for="dp">Data do Post</label>
								<input type="text" class="form-control date-picker mk-data" value="<?=$rs->dp?datef($rs->dp,8):''?>" name="dp" id="dp" placeholder="Data do post">
							</div>
							<div class="form-group col-md-12">
								<label class="control-label" for="d">* Descrição</label>
								<div>
									<progress style="display:none;margin-bottom:10px;width:100%"></progress>
									<textarea class="summernote" id="d" name="d"><?=strh($rs->d)?></textarea>
								</div>
							</div>
							<div class="form-group col-md-12">
								<label for="r">* Resumo</label>
								<textarea class="form-control" id="r" name="r" placeholder="Digite o resumo da descrição" rows="8"><?=strh($rs->r)?></textarea>
							</div>
						</div>
<?
if($s->id){
?>
						<div class="tab-pane fade" id="tab2">
<?
	if($sfotos->rowCount()){
		while($rfotos=$sfotos->fetchObject()){
?>
							<div class="form-group col-xs-12 col-lg-3">
								<label for="principal-<?=$rfotos->id?>" class="text-center">
									<img src="upload/objetivos/thumb/<?=$rfotos->it?>" class="view-imgs"/>
									<input type="radio" id="principal-<?=$rfotos->id?>" name="principal" value="<?=$rfotos->id?>" <?=$rfotos->principal?'checked':''?>/>
									IMAGEM PRINCIPAL
								</label>
							</div>
<?
		}
?>
							<div class="clearfix"></div>
							<a href="admin/<?=$s->spg?>-foto/<?=$s->id?>" class="btn btn-danger">REMOVER FOTOS</a>
<?
	}else echo '<a href="admin/'.$s->spg.'-foto/'.$s->id.'" class="btn btn-success">ADICIONAR FOTOS</a>';
?>
						</div>
<?
}
?>
						<div class="tab-pane fade" id="tab3">
							<div class="form-group col-md-12">
								<label for="idp">Produtos Relacionado</label>
								<select class="js-produtos form-control" id="idp" tabindex="-1" style="width:100%" name="idp[]" multiple>
<?
if($s->id){
	$st = $b->query("select p.idp from objetivo o left join objetivo_produto p on o.id=p.ido where p.ido='{$s->id}' order by o.t");
	while($rt=$st->fetchObject()){
		$rp = $b->query("select p.h1,f.i from produto p left join fotos f on p.id=f.idp and f.tipo='produto' where p.id='{$rt->idp}' order by p.t")->fetchObject();
		$rp->i = $rp->i?$rp->i:'thumb/default.jpg';
?>
									<option value="<?=$rt->idp?>" selected data-image="<?=$rp->i?>"><?=$rp->h1?></option>
<?
	}
}
?>
								</select>
							</div>
						</div>
						<div class="tab-pane fade" id="tab4">
							<div class="form-group col-md-12">
								<label for="tagt">Meta Title</label>
								<input type="text" class="form-control" id="tagt" name="tagt" placeholder="Digite a Meta Tag title" value="<?=strh($rs->tagt)?>">
							</div>
							<div class="form-group col-md-12">
								<label for="tagd">Meta Description</label>
								<textarea class="form-control" id="tagd" name="tagd" placeholder="Digite a Meta Tag description" rows="8"><?=strh($rs->tagd)?></textarea>
							</div>
							<div class="clearfix"></div>
							<div class="container-seo form-group col-md-12">
								<div class="wrapper">
									<div class="main">
										<h3>PRÉVIA <i class="fa fa-question-circle" data-toggle="tooltip" title="" style="font-size:16px" data-original-title="Este é um exemplo de como este artigo pode aparecer nos resultados de busca do Google."></i></h3>
										<div class="title-seo">
											<span><?=strh($rs->tagt)?></span>
										</div>
<?
if($s->id){
?>
										<div class="url-seo">
											<span><?=$url_seo?></span>
										</div>
<?
}
?>
										<div class="description-seo">
											<span><?=strh($rs->tagd)?></span>
										</div>
									</div>
								</div>
							</div>
						</div>
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
						<ul class="pager wizard">
							<li class="previous"><a href="admin/<?=$s->spg.($s->id?'/'.$s->id:'')?>#" class="btn btn-default">Anterior</a></li>
							<li class="next"><a href="admin/<?=$s->spg.($s->id?'/'.$s->id:'')?>#" class="btn btn-default">Próximo</a></li>
						</ul>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?
Inline::a();
?>
<link href="assets/css/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" type="text/css"/>
<link href="assets/css/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="assets/js/admin/jquery.validate.min.js"></script>
<script type="text/javascript" src="assets/js/admin/jquery.bootstrap.wizard.min.js"></script>
<script type="text/javascript" src="assets/js/jscolor/jscolor.js"></script>
<script type="text/javascript" src="assets/js/admin/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="assets/js/admin/select2.min.js"></script>
<script type="text/javascript">
var adm = $.form({
	a:'objetivo',
	load:function(_,F,f,e,o,i){
		$('.mk-data').mask('99/99/9999');
	},
});
</script>
<script type="text/javascript">
$.extend(adm,<?=json_encode($a)?>);
</script>
<script type="text/javascript">
$(document).ready(function() {
	/*var validator = $('#id-form').validate({
		rules: {
			n: {
				required: true
			},
			r: {
				required: true
			},
			i:{required: "<?=$s->id?'false':'true'?>"},
		}
	});*/
	$('#rootwizard').bootstrapWizard({
		'tabClass': 'nav nav-tabs',
		onTabShow: function(tab, navigation, index) {
			var total = navigation.find('li').length;
			var current = index+1;
			var percent = (current/total) * 100;
			$('#rootwizard').find('.progress-bar').css({width:percent+'%'});
		},
		'onNext': function(tab, navigation, index) {
			var valid = $('#id-form').valid();
			if(!valid) {
				validator.focusInvalid();
				return false;
			}
		},
		'onTabClick': function(tab, navigation, index) {
			var valid = $('#id-form').valid();
			if(!valid) {
				validator.focusInvalid();
				return false;
			}
		},
	});
	$('.date-picker').datepicker({
		format: 'dd/mm/yyyy',
    });
});
$(document).ready(function() {
	$.fn.select2.amd.require(['select2/selection/search'], function (Search) {
		var oldRemoveChoice = Search.prototype.searchRemoveChoice;
		
		Search.prototype.searchRemoveChoice = function () {
			oldRemoveChoice.apply(this, arguments);
			this.$search.val('');
		};
		function formatState (data) {
			if (!data.id)return data.text;
			var image = $(data.element).data('image');
			var datad = $(
				'<span><img width=\"100\" src=\"'+(data.image?data.image:'upload/aplicacoes/'+image+'')+'\" class=\"img-flag\" style=\"margin-right:15px\">'+data.text+'</span>'
			);
			return datad;
		};
	});
});

$(document).ready(function() {
	$.fn.select2.amd.require(['select2/selection/search'], function (Search) {
		var oldRemoveChoice = Search.prototype.searchRemoveChoice;
		
		Search.prototype.searchRemoveChoice = function () {
			oldRemoveChoice.apply(this, arguments);
			this.$search.val('');
		};
		$('.js-produtos').select2({
			placeholder: 'Buscar Produtos',
			ajax: {
				url:'ajax/g/produtos.json',
				dataType:'json',
				delay:250,
				data:function(params){
					return{
						q:params.term,
<?
if($s->id){
?>
						id:<?=$s->id?>
<?
}
?>
					};
				},
				processResults:function(data){
					return {
						results: data
					};
				},
				cache: true
			},
			minimumInputLength: 2,
			templateResult:formatState,
			templateSelection:formatState,
		});
		function formatState (data) {
			if (!data.id)return data.text;
			var image = $(data.element).data('image');
			var datad = $(
				'<span><img width=\"100\" src=\"'+(data.image?data.image:'upload/produtos/'+image+'')+'\" class=\"img-flag\" style=\"margin-right:15px\">'+data.text+'</span>'
			);
			return datad;
		};
	});
});
</script>
<?
echo $s->summernote();
Inline::b();
?>