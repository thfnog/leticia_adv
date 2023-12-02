<div class="col-md-12">
	<div class="panel panel-white">
		<div class="panel-heading clearfix">
			<h4 class="panel-title"><?=$s->id?'Alterar':'Novo'?> Produto</h4>
		</div>
		<div class="panel-body">
			<div id="rootwizard">
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#tab1" data-toggle="tab"><i class="fa fa-user m-r-xs"></i>Geral</a></li>
<?
$sfotos = $b->query("select * from fotos where idp='{$s->id}' and tipo='produto'");
if($s->id){
?>
					<li role="presentation"><a href="#tab2" data-toggle="tab"><i class="fa fa-image m-r-xs"></i>Imagens</a></li>
<?
}
?>
					<li role="presentation"><a href="#tab3" data-toggle="tab"><i class="fa icon-size-actual m-r-xs"></i>Medidas / Preço</a></li>
					<li role="presentation"><a href="#tab4" data-toggle="tab"><i class="fa fa-cog m-r-xs"></i>Produtos Relacionados</a></li>
					<?php /*?><li role="presentation"><a href="#tab5" data-toggle="tab"><i class="fa fa-file m-r-xs"></i>Arquivo Download</a></li><?php */?>
					<li role="presentation"><a href="#tab6" data-toggle="tab"><i class="fa fa-google m-r-xs"></i>SEO</a></li>
				</ul>
				<div class="progress progress-sm m-t-sm">
					<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
					</div>
				</div>
				<form id="id-form">
					<div class="tab-content">
						<div class="tab-pane active fade in" id="tab1">
							<div class="form-group col-md-12">
								<label for="idc">* Categoria</label>
								<select class="form-control" name="idc" id="idc"></select>
								<?php /*?><select class="js-categorias form-control" id="idc" multiple="multiple" tabindex="-1" style="width:100%" name="idc[]">
<?
if($s->id){
	$st = $b->query("select c.id,c.n from cat c left join produto_cat p on c.id=p.idc where p.idp='{$s->id}' order by c.t");
	while($rt=$st->fetchObject()){
?>
									<option value="<?=$rt->id?>" selected="selected"><?=$rt->n?></option>
<?
	}
}
?>
								</select><?php */?>
							</div>
							<?php /*?><div class="form-group col-md-12">
								<label for="idc2">Categoria 2</label>
								<select class="form-control" name="idc2" id="idc2"></select>
							</div>
							<div class="form-group col-md-12">
								<label for="idc3">Categoria 3</label>
								<select class="form-control" name="idc3" id="idc3"></select>
							</div>
							<div class="form-group col-md-12">
								<label for="idm">* Marca</label>
								<select class="form-control" name="idm" id="idm"></select>
							</div><?php */?>
							<div class="form-group col-md-12 show">
								<label for="h1">* Título (H1)</label>
								<input type="text" class="form-control" id="h1" name="h1" placeholder="Digite o título (h1)" value="<?=strh($rs->h1)?>">
							</div>
							<div class="form-group col-md-12 show">
								<label for="h2">Subtítulo (H2)</label>
								<input type="text" class="form-control" id="h2" name="h2" placeholder="Digite o subtítulo (h2)" value="<?=strh($rs->h2)?>">
							</div>
							<div class="form-group col-md-12">
								<label for="n">* Slug (usado para url do produto)</label>
								<input type="text" class="form-control" id="n" name="n" placeholder="Digite o slug (usado para url do blog)" value="<?=strh($rs->n)?>">
							</div>
							<div class="form-group col-md-12">
								<label for="sku">* SKU da TID</label>
								<input type="text" class="form-control" id="sku" name="sku" placeholder="Digite o sku equivalente a esse produto na TID" value="<?=strh($rs->sku)?>">
							</div>
							<div class="form-group col-md-12">
								<label for="c">Código</label>
								<input type="text" class="form-control" id="c" name="c" placeholder="Digite o código" value="<?=strh($rs->c)?>">
							</div>
							<div class="form-group col-md-12">
								<label class="control-label" for="obs">* Descrição Curta</label>
								<textarea class="form-control" rows="7" id="obs" name="obs"><?=strh($rs->obs)?></textarea>
							</div>
							<div class="form-group col-md-12">
								<label class="control-label" for="d">* Descrição Geral</label>
								<div>
									<progress style="display:none;margin-bottom:10px;width:100%"></progress>
									<textarea class="summernote" id="d" name="d"><?=strh($rs->d)?></textarea>
								</div>
							</div>
							<div class="form-group col-md-12">
								<label class="control-label" for="nutricional">* Informação Nutricional</label>
								<div>
									<progress style="display:none;margin-bottom:10px;width:100%"></progress>
									<textarea class="summernote" id="nutricional" name="nutricional"><?=strh($rs->nutricional)?></textarea>
								</div>
							</div>
							<div class="form-group col-md-12">
								<label class="control-label" for="ingredientes">Ingredientes</label>
								<textarea class="form-control" rows="7" id="ingredientes" name="ingredientes"><?=strh($rs->ingredientes)?></textarea>
							</div>
							<div class="form-group col-md-12">
								<label class="control-label" for="diabeticos">Diabéticos e Alérgicos</label>
								<textarea class="form-control" rows="7" id="diabeticos" name="diabeticos"><?=strh($rs->diabeticos)?></textarea>
							</div>
							<div class="form-group col-md-12">
								<label class="control-label" for="sugestao">Sugestão de Uso</label>
								<textarea class="form-control" rows="7" id="sugestao" name="sugestao"><?=strh($rs->sugestao)?></textarea>
							</div>
							<div class="form-group col-md-12">
								<label class="control-label" for="recomendacao">Recomendação de Uso</label>
								<textarea class="form-control" rows="7" id="recomendacao" name="recomendacao"><?=strh($rs->recomendacao)?></textarea>
							</div>
							<?php /*?><div class="form-group col-md-12">
								<label class="control-label" for="tecnico">Detalhes Técnicos</label>
								<div>
									<progress style="display:none;margin-bottom:10px;width:100%"></progress>
									<textarea class="summernote" id="tecnico" name="tecnico"><?=strh($rs->tecnico)?></textarea>
								</div>
							</div><?php */?>
							<!--<div class="form-group col-md-12">
								<label class="control-label" for="r">* Resumo</label>
								<textarea class="form-control" rows="7" id="r" name="r"><?=strh($rs->r)?></textarea>
							</div>-->
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
									<img src="upload/produtos/thumb/<?=$rfotos->it?>" class="view-imgs"/>
									<input type="radio" id="principal-<?=$rfotos->id?>" name="principal" value="<?=$rfotos->id?>" <?=$rfotos->principal?'checked':''?>/>
									IMAGEM PRINCIPAL
								</label>
								<label for="hover-<?=$rfotos->id?>" class="text-center">
									<input type="radio" id="hover-<?=$rfotos->id?>" name="hover" value="<?=$rfotos->id?>" <?=$rfotos->hover?'checked':''?>/>
									IMAGEM HOVER
								</label>
							</div>
<?
		}
?>
							<div class="clearfix"></div>
							<a href="admin/produto-foto/<?=$s->id?>" class="btn btn-danger">ALTERAR FOTOS</a>
<?
	}else echo '<a href="admin/produto-foto/'.$s->id.'" class="btn btn-success">ADICIONAR FOTOS</a>';
?>
						</div>
<?
}
?>
						<div class="tab-pane fade" id="tab3">
							<div class="form-group col-md-3 col-xs-12">
								<label for="largura">* Largura (cm) <i class="fa fa-question-circle" data-toggle="tooltip" title="" style="font-size:16px" data-original-title="A largura não pode ser maior que 105 cm. A soma resultante do comprimento + largura + altura não deve superar a 200 cm"></i></label>
								<input type="number" class="form-control" id="largura" name="largura" placeholder="Digite a largura do produto" value="<?=strh($rs->largura)?>"/>
							</div>
							<div class="form-group col-md-3 col-xs-12">
								<label for="altura">* Altura (cm) <i class="fa fa-question-circle" data-toggle="tooltip" title="" style="font-size:16px" data-original-title="A altura não pode ser maior que 105 cm. A soma resultante do comprimento + largura + altura não deve superar a 200 cm"></i></label>
								<input type="number" class="form-control" id="altura" name="altura" placeholder="Digite a altura do produto" value="<?=strh($rs->altura)?>"/>
							</div>
							<div class="form-group col-md-3 col-xs-12">
								<label for="comprimento">* Comprimento (cm) <i class="fa fa-question-circle" data-toggle="tooltip" title="" style="font-size:16px" data-original-title="O comprimento não pode ser maior que 105 cm. A soma resultante do comprimento + largura + altura não deve superar a 200 cm"></i></label>
								<input type="number" class="form-control" id="comprimento" name="comprimento" placeholder="Digite o comprimento do produto" value="<?=strh($rs->comprimento)?>"/>
							</div>
							<div class="form-group col-md-3 col-xs-12">
								<label for="peso">* Peso (kg) <i class="fa fa-question-circle" data-toggle="tooltip" title="" style="font-size:16px" data-original-title="O peso não pode ser maior que 30kg"></i></label>
								<input type="number" class="form-control" id="peso" name="peso" placeholder="Digite o peso do produto" value="<?=strh($rs->peso)?>"/>
							</div>
							<div class="form-group col-md-4 col-xs-12">
								<label for="v">* Valor:</label>
								<input type="number" min="0.01" step="0.10" class="form-control" id="v" name="v" placeholder="Digite o valor do produto" value="<?=strh($rs->v)?>"/>
							</div>
							<div class="form-group col-md-4 col-xs-12">
								<label for="estoque">Estoque:</label>
								<input type="number" min="0" step="1" class="form-control" id="estoque" name="estoque" value="<?=strh($rs->estoque)?>"/>
							</div>
							<div class="form-group col-md-4 col-xs-12">
								<label for="estoque_minimo">Estoque Mínimo:</label>
								<input type="number" min="0" step="1" class="form-control" id="estoque_minimo" name="estoque_minimo" value="<?=strh($rs->estoque_minimo)?>"/>
							</div>
						</div>
						<div class="tab-pane fade" id="tab4">
							<div class="form-group col-md-12">
								<label for="idp">Produtos Relacionados</label>
								<select class="js-produtos form-control" id="idp" multiple="multiple" tabindex="-1" style="width:100%" name="idp[]">
<?
if($s->id){
	$sr = $b->query("select * from produto_relacionado where idp='{$s->id}' or idp2='{$s->id}'");
	while($rr=$sr->fetchObject()){
		$idp = $rr->idp==$s->id?$rr->idp2:$rr->idp;
		$rp = $b->query("select p.h1,f.i from produto p left join fotos f on p.id=f.idp and f.tipo='produto' where p.id='$idp' order by p.t")->fetchObject();
		$rp->i = $rp->i?$rp->i:'thumb/default.jpg';
?>
									<option value="<?=$rr->idp==$s->id?$rr->idp2:$rr->idp?>" selected data-image="<?=$rp->i?>"><?=$rp->h1?></option>
<?
	}
}
?>
								</select>
							</div>
						</div>
						<?php /*?><div class="tab-pane fade" id="tab5">
							<div class="form-group col-md-12">
								<label for="f">* Arquivo (ZIP ou RAR):</label>
								<input type="file" name="f" class="txt left mr"/>
								<div class="clearfix"></div>
								<div id="text-view-f" class="text-view col-sm-6" cls="top">
									<label class="top">Remover Arquivo:<input type="checkbox" name="rf" value="1" class="ckb"/></label>
								</div>
							</div>
						</div><?php */?>
						<div class="tab-pane fade" id="tab6">
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
						<div class="clearfix"></div>
						<div class="form-group col-md-12">
							<label for="home">
								<span style="display:block;float:left;margin-right:5px">Mostrar na Home</span>
								<span><input type="checkbox" id="home" name="home" value="1" class="ckb"<?=$rs->home||!$s->id?' checked':''?>></span>
							</label>
						</div>
						<div class="form-group col-md-12">
							<label for="s">
								<span style="display:block;float:left;margin-right:5px">Ativo</span>
								<span><input type="checkbox" id="s" name="s" value="1" class="ckb"<?=$rs->s||!$s->id?' checked':''?>></span>
							</label>
						</div>
						<div class="clearfix" style="height:40px"></div>
						<div class="form-group col-md-12 show">
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
<link href="assets/css/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="assets/js/admin/jquery.validate.min.js"></script>
<script type="text/javascript" src="assets/plugins/summernote/summernote.js"></script>
<script type="text/javascript" src="assets/plugins/summernote/lang/summernote-pt-BR.js"></script>
<script type="text/javascript" src="assets/js/admin/jquery.bootstrap.wizard.min.js"></script>
<script type="text/javascript" src="assets/js/admin/select2.min.js"></script>
<script type="text/javascript">
var adm = $.form({
	a:'produto',
	load:function(_,F,f,e,o,i){
		e = f.idc;
		o = e.options;
		$.each(_.cat,function(i,v){
			o[i=o.length] = new Option(v[0],v[1]);
			if(v[1]==_.idc)e.selectedIndex = i;
		});

		/*e = f.idc2;
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

		e = f.idm;
		o = e.options;
		$.each(_.mar,function(i,v){
			o[i=o.length] = new Option(v[0],v[1]);
			if(v[1]==_.idm)e.selectedIndex = i;
		});*/
	}
});
</script>
<script type="text/javascript">
$.extend(true,adm,<?=json_encode($a)?>);
</script>
<script type="text/javascript">
$(document).ready(function() {
	var validator = $('#id-form').validate({
		rules: {
			h1: {required: true},
			//n: {required: true},
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
});
$(document).ready(function() {
	$.fn.select2.amd.require(['select2/selection/search'], function (Search) {
		var oldRemoveChoice = Search.prototype.searchRemoveChoice;
		
		Search.prototype.searchRemoveChoice = function () {
			oldRemoveChoice.apply(this, arguments);
			this.$search.val('');
		};
		$('.js-categorias').select2({
			placeholder: 'Buscar Categorias',
			ajax: {
				url:'ajax/g/categorias.json',
				dataType:'json',
				delay:250,
				data:function(params){
					return{
						q:params.term
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
		});
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
		$('.js-sabores').select2({
			placeholder: 'Buscar Sabores',
			ajax: {
				url:'ajax/g/sabores.json',
				dataType:'json',
				delay:250,
				data:function(params){
					return{
						q:params.term
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
		});
		$('.js-pesos').select2({
			placeholder: 'Buscar Pesos',
			ajax: {
				url:'ajax/g/pesos.json',
				dataType:'json',
				delay:250,
				data:function(params){
					return{
						q:params.term
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
		url:'ajax/i/produto.json',
		cache: false,
		contentType: false,
		processData: false,
		success: function(x){
			$('.summernote').summernote("insertImage", x.url);
		}
	});
}
function progressHandlingFunction(e){
	if(e.lengthComputable){
		$('progress').show().attr({value:e.loaded, max:e.total});
		if(e.loaded==e.total)$('progress').attr('value','0.0').hide();
	}
}
</script>
<?
Inline::b();
?>