<div class="col-md-12">
	<div class="panel panel-white">
		<div class="panel-heading clearfix">
			<h4 class="panel-title">Alterar <?=$rs->n?></h4>
		</div>
		<div class="panel-body">
			<form id="id-form">
				<div class="form-group col-md-12">
					<label for="n">* Título</label>
					<input type="text" class="form-control" id="n" name="n" placeholder="Digite o título" value="<?=strh($rs->n)?>">
				</div>
				<div class="form-group col-md-12">
					<label class="control-label" for="d">* Descrição</label>
					<div>
						<progress style="display:none;margin-bottom:10px;width:100%"></progress>
						<textarea class="summernote" id="d" name="d"><?=strh($rs->d)?></textarea>
					</div>
				</div>
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
			</form>
		</div>
	</div>
</div>
<?
Inline::a();
?>
<link href="assets/css/summernote.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="assets/js/admin/summernote.min.js"></script>
<script type="text/javascript">
var adm = $.form({
	a:'termo',
	load:function(_,F,f,e,o,i){}
});
</script>
<script type="text/javascript">
$.extend(adm,<?=json_encode($a)?>);
</script>
<script type="text/javascript">
$('.summernote').summernote({
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
		['insert', ['link', '', 'hr']],
		['view', ['fullscreen', 'codeview']],
		['help', ['help']]
	],
	onpaste : function (e)  {
		var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
        e.preventDefault();
        document.execCommand('insertText', false, bufferText);
    }
});
</script>
<?
Inline::b();
?>