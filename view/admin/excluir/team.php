<div class="col-md-12">
	<div class="panel panel-white">
		<div class="panel-heading clearfix">
			<h4 class="panel-title"><?=$s->id?'Alterar':'Novo'?> Membro</h4>
		</div>
		<div class="panel-body">
			<div id="rootwizard">
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#tab1" data-toggle="tab"><i class="fa fa-user m-r-xs"></i>Geral</a></li>
<?
$sfotos = $b->query("select * from fotos where idp='{$s->id}' and tipo='team'");
if($s->id){
?>
					<li role="presentation"><a href="#tab2" data-toggle="tab"><i class="fa fa-image m-r-xs"></i>Imagens</a></li>
<?
}
?>
				</ul>
				<div class="progress progress-sm m-t-sm">
					<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
					</div>
				</div>
				<form id="id-form">
					<div class="tab-content">
						<div class="tab-pane active fade in" id="tab1">
							<div class="form-group col-md-12">
								<label for="nome">* Nome</label>
								<input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome" value="<?=strh($rs->nome)?>">
							</div>
							<div class="form-group col-md-12">
								<label for="funcao">* Função</label>
								<input type="text" class="form-control" id="funcao" name="funcao" placeholder="Digite a função" value="<?=strh($rs->funcao)?>">
							</div>
							<div class="form-group col-md-12">
								<label for="facebook">Facebook</label>
								<input type="text" class="form-control" id="facebook" name="facebook" placeholder="Digite o facebook" value="<?=strh($rs->facebook)?>">
							</div>
							<div class="form-group col-md-12">
								<label for="instagram">Instagram</label>
								<input type="text" class="form-control" id="instagram" name="instagram" placeholder="Digite o instagram" value="<?=strh($rs->instagram)?>">
							</div>
							<div class="form-group col-md-12">
								<label for="twitter">Twitter</label>
								<input type="text" class="form-control" id="twitter" name="twitter" placeholder="Digite o twitter" value="<?=strh($rs->twitter)?>">
							</div>
							<div class="form-group col-md-12">
								<label for="linkedin">Linkedin</label>
								<input type="text" class="form-control" id="linkedin" name="linkedin" placeholder="Digite o linkedin" value="<?=strh($rs->linkedin)?>">
							</div>
							<div class="form-group col-md-12">
								<label for="youtube">YouTube</label>
								<input type="text" class="form-control" id="youtube" name="youtube" placeholder="Digite o youtube" value="<?=strh($rs->youtube)?>">
							</div>
							<div class="form-group col-md-12">
								<label for="pinterest">Pinterest</label>
								<input type="text" class="form-control" id="pinterest" name="pinterest" placeholder="Digite o pinterest" value="<?=strh($rs->pinterest)?>">
							</div>
							<div class="form-group col-md-12">
								<label for="plus">Google Plus</label>
								<input type="text" class="form-control" id="plus" name="plus" placeholder="Digite o plus" value="<?=strh($rs->plus)?>">
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
									<img src="upload/team/thumb/<?=$rfotos->it?>" class="view-imgs"/>
									<input type="radio" id="principal-<?=$rfotos->id?>" name="principal" value="<?=$rfotos->id?>" <?=$rfotos->principal?'checked':''?>/>
									IMAGEM PRINCIPAL
								</label>
							</div>
<?
		}
?>
							<div class="clearfix"></div>
							<a href="admin/team-foto/<?=$s->id?>" class="btn btn-danger">ALTERAR FOTOS</a>
<?
	}else echo '<a href="admin/team-foto/'.$s->id.'" class="btn btn-success">ADICIONAR FOTOS</a>';
?>
						</div>
<?
}
?>
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
	a:'team',
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
			placeholder: 'Buscar Produtos Relacionados',
			ajax: {
				url:'ajax/g/produto-relacionado.json',
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