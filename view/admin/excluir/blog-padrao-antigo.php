<div class="col-md-12">
	<div class="panel panel-white">
		<div class="panel-heading clearfix">
			<h4 class="panel-title"><?=$s->id?'Alterar':'Novo'?> Post</h4>
		</div>
		<div class="panel-body">
			<div id="rootwizard">
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#tab1" data-toggle="tab"><i class="fa fa-user m-r-xs"></i>Geral</a></li>
<?
$sfotos = $b->query("select * from fotos where idp='{$s->id}' and tipo='blog'");
if($s->id){
?>
					<li role="presentation"><a href="#tab2" data-toggle="tab"><i class="fa fa-image m-r-xs"></i>Imagens</a></li>
<?
}
?>
					<li role="presentation"><a href="#tab3" data-toggle="tab"><i class="fa fa-cog m-r-xs"></i>Produto</a></li>
					<li role="presentation"><a href="#tab4" data-toggle="tab"><i class="fa fa-search m-r-xs"></i>Tags</a></li>
					<li role="presentation"><a href="#tab5" data-toggle="tab"><i class="fa fa-google m-r-xs"></i>SEO</a></li>
				</ul>
				<div class="progress progress-sm m-t-sm">
					<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
					</div>
				</div>
				<form id="id-form">
					<input type="hidden" name="table" value="blog"/>
					<div class="tab-content">
						<div class="tab-pane active fade in" id="tab1">
							<div class="form-group col-md-12">
								<label for="tipo">* Tipo de Post</label>
								<select class="form-control" id="tipo" name="tipo"></select>
							</div>
							<div class="form-group col-md-12 atletas">
								<label for="nome">* Nome do Atleta</label>
								<input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome do atleta" value="<?=strh($rs->nome)?>">
							</div>
							<div class="form-group col-md-12">
								<label for="h1">* Título (H1)</label>
								<input type="text" class="form-control" id="h1" name="h1-strs" placeholder="Digite o título (h1)" value="<?=strh($rs->h1)?>">
							</div>
							<div class="form-group col-md-12">
								<label for="n">* Slug (usado para url do blog)</label>
								<input type="text" class="form-control" id="n" name="n" placeholder="Digite o slug (usado para url do blog)" value="<?=strh($rs->n)?>">
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
							<div class="atletas">
								<div class="form-group col-md-12">
									<label for="facebook">Facebook</label>
									<input type="text" class="form-control" id="facebook" name="facebook" placeholder="Digite o facebook do atleta" value="<?=strh($rs->facebook)?>">
								</div>
								<div class="form-group col-md-12">
									<label for="instagram">Instagram</label>
									<input type="text" class="form-control" id="instagram" name="instagram" placeholder="Digite o instagram do atleta" value="<?=strh($rs->instagram)?>">
								</div>
								<div class="form-group col-md-12">
									<label for="twitter">Twitter</label>
									<input type="text" class="form-control" id="twitter" name="twitter" placeholder="Digite o twitter do atleta" value="<?=strh($rs->twitter)?>">
								</div>
								<div class="form-group col-md-12">
									<label for="pinterest">Pinterest</label>
									<input type="text" class="form-control" id="pinterest" name="pinterest" placeholder="Digite o pinterest do atleta" value="<?=strh($rs->pinterest)?>">
								</div>
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
									<img src="upload/blogs/thumb/<?=$rfotos->it?>" class="view-imgs"/>
									<input type="radio" id="principal-<?=$rfotos->id?>" name="principal" value="<?=$rfotos->id?>" <?=$rfotos->principal?'checked':''?>/>
									IMAGEM PRINCIPAL
								</label>
							</div>
<?
		}
?>
							<div class="clearfix"></div>
							<a href="admin/blog-foto/<?=$s->id?>" class="btn btn-danger">REMOVER FOTOS</a>
<?
	}else echo '<a href="admin/blog-foto/'.$s->id.'" class="btn btn-success">ADICIONAR FOTOS</a>';
?>
						</div>
<?
}
?>
						<div class="tab-pane fade" id="tab3">
							<div class="form-group col-md-12">
								<label for="idp">Produto Relacionado</label>
								<select class="js-produtos form-control" id="idp" tabindex="-1" style="width:100%" name="idp">
<?
if($s->id){
	$idp = $rs->idp;
	$rp = $b->query("select p.h1,f.i from produto p left join fotos f on p.id=f.idp where p.id='$idp' order by p.t")->fetchObject();
	$rp->i = $rp->i?$rp->i:'thumb/default.jpg';
?>
									<option value="<?=$rs->idp?>" selected data-image="<?=$rp->i?>"><?=$rp->h1?></option>
<?
}
?>
								</select>
							</div>
							<div class="atletas form-group col-md-12">
								<label for="i">Imagem:</label>
								<input type="file" name="i" class="txt left mr"/>
								<div class="text left ml"><span><strong>Largura mínima:</strong> 1200px</span><span><strong>Altura mínima:</strong> 1100px</span></div>
								<div class="clearfix"></div>
								<div id="img-view-i" class="img-view col-sm-6" cls="top">
									<label class="top">Remover Imagem:<input type="checkbox" name="ri" value="1" class="ckb"/></label>
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="tab4">
							<div class="form-group col-md-12">
								<label for="tags">Tags</label>
<?
$sp = $b->query("select id,n from tag where idp={$s->id} and tipo='blog' order by n");
$count = $sp->rowCount();
$pj = 0;
?>
								<textarea class="form-control" id="tags" name="tags" placeholder="Digite as tags separando com  vírgula e espaço!" rows="8">
<?
while($rp=$sp->fetchObject()){
	$pj++;
	if($s->id&&$rp->n)echo strh($rp->n).($pj<$count?", ":"");
}
?></textarea>
							</div>
						</div>
						<div class="tab-pane fade" id="tab5">
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
<link href="assets/plugins/summernote/summernote.css" rel="stylesheet" type="text/css"/>
<link href="assets/css/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" type="text/css"/>
<link href="assets/css/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="assets/js/admin/jquery.validate.min.js"></script>
<script type="text/javascript" src="assets/plugins/summernote/summernote.js"></script>
<script type="text/javascript" src="assets/plugins/summernote/lang/summernote-pt-BR.js"></script>
<script type="text/javascript" src="assets/js/admin/jquery.bootstrap.wizard.min.js"></script>
<script type="text/javascript" src="assets/js/jscolor/jscolor.js"></script>
<script type="text/javascript" src="assets/js/admin/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="assets/js/admin/select2.min.js"></script>
<script type="text/javascript">
var adm = $.form({
	a:'blog',
	cgT:function(h){
		var _ = this,f = _.f,tipo = $(this.f.tipo).val();
		$('.atletas')[tipo=='atletas'?'show':'hide']();
	},
	load:function(_,F,f,e,o,i){
		$('.mk-data').mask('99/99/9999');

		e = f.tipo;
		o = e.options;
		$.each(_.tp,function(i,v){
			o[i=o.length] = new Option(v[0],v[1]);
			if(v[1]==_.tipo)e.selectedIndex = i;
		});
		$(e).change(function(){
			_.cgT();
		});
		_.cgT(0);
	},
	tp:[['-- Selecione o Tipo de Post --',0],['Patrocinados','atletas'],['Novidades','novidades'],['Receitas','receitas'],['Treinos','treinos']]
});
</script>
<script type="text/javascript">
$.extend(adm,<?=json_encode($a)?>);
</script>
<script type="text/javascript">
$(document).ready(function() {
	var validator = $('#id-form').validate({
		rules: {
			n: {
				required: true
			},
			r: {
				required: true
			},
			i:{required: "<?=$s->id?'false':'true'?>"},
		}
	});
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
setTimeout(function(){
	$('.summernote').summernote({
		lang: 'pt-BR',
		height: 350,
		styleWithSpan: false,
		toolbar: [
			['style', ['style']],
			['font', ['bold', 'italic', 'underline', 'clear']],
			//['fontname', ['fontname']],
			['color', ['color']],
			['para', ['ul', 'ol', 'paragraph']],
			['height', ['height']],
			['table', ['table']],
			['insert', ['link', 'picture', 'video', 'hr']],
			['view', ['fullscreen', 'codeview']],
			['help', ['help']]
		],
		callbacks: {
			onPaste: function(e) {
				var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
				e.preventDefault();
				document.execCommand('insertText', false, bufferText);
			},
			onImageUpload: function(files, editor, welEditable) {
				sendFile(files[0], editor, welEditable);
			}
	  }
	});
},1000);
function sendFile(file, editor, welEditable) {
	data = new FormData();
	data.append('file',file);
	$.ajax({
		data: data,
		type:'POST',
		xhr: function() {
			var myXhr = $.ajaxSettings.xhr();
			if (myXhr.upload) myXhr.upload.addEventListener('progress',progressHandlingFunction, false);
			return myXhr;
		},
		url:'ajax/i/blog.json',
		cache: false,
		contentType: false,
		processData: false,
		success: function(x){
			$('.summernote').summernote("insertImage", x.url);
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log(textStatus+" "+errorThrown);
		}
	});
}
function progressHandlingFunction(e){
	if(e.lengthComputable){
		$('progress').show().attr({value:e.loaded, max:e.total});
		if(e.loaded==e.total)$('progress').attr('value','0.0').hide();
	}
}
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
Inline::b();
?>