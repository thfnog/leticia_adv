<div class="col-md-12">
	<div class="panel panel-white">
		<div class="panel-heading clearfix">
			<h4 class="panel-title"><?=$s->id?'Alterar':'Nova'?> Categoria</h4>
		</div>
		<div class="panel-body">
			<form id="id-form">
				<div class="form-group col-md-12">
					<label for="h1">* Título (h1)</label>
					<input type="text" class="form-control" id="h1" name="h1" placeholder="Digite o título h1" value="<?=strh($rs->h1)?>">
				</div>
				<div class="form-group col-md-12">
					<label for="n">* Slug (usado para url da categoria)</label>
					<input type="text" class="form-control" id="n" name="n" placeholder="Digite o slug" value="<?=strh($rs->n)?>">
				</div>
				<div class="form-group col-md-12">
					<label for="idc">Categoria Pai</label>
					<select class="form-control" id="idc" name="idc" style="text-transform:uppercase"></select>
				</div>
				<!--<div class="form-group col-md-12">
					<label class="control-label" for="d">Descrição</label>
					<div>
						<progress style="display:none;margin-bottom:10px;width:100%"></progress>
						<textarea class="summernote" id="d" name="d"><?=strh($rs->d)?></textarea>
					</div>
				</div>-->
				<?php /*?><div class="form-group col-md-12">
					<label for="i">Imagem:</label>
					<input type="file" name="i" class="txt left mr"/>
					<div class="text left ml"><span><strong>Largura mínima:</strong> 1920px</span><span><strong>Altura mínima:</strong> 300px</span></div>
					<div class="clearfix"></div>
					<div id="img-view-i" class="img-view col-sm-6" cls="top">
						<label class="top">Remover Imagem:<input type="checkbox" name="ri" value="1" class="ckb"/></label>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="form-group col-md-12">
					<label for="ih">Imagem da Home:</label>
					<input type="file" name="ih" class="txt left mr"/>
					<div class="text left ml"><span><strong>Largura mínima:</strong> 120px</span><span><strong>Altura mínima:</strong> 180px</span></div>
					<div class="clearfix"></div>
					<div id="img-view-ih" class="img-view col-sm-6" cls="top">
						<label class="top">Remover Imagem:<input type="checkbox" name="rih" value="1" class="ckb"/></label>
					</div><?php */?>
				</div>
				<div class="clearfix"></div>
				<div class="form-group col-md-12">
					<label for="tagt">Meta Title</label>
					<input type="text" class="form-control" id="tagt" name="tagt" placeholder="Digite a Meta Tag title" value="<?=strh($rs->tagt)?>">
				</div>
				<div class="form-group col-md-12">
					<label for="tagd">Meta Description</label>
					<textarea class="form-control" id="tagd" name="tagd" placeholder="Digite a Meta Tag description" rows="8"><?=strh($rs->tagd)?></textarea>
				</div>
				<div class="form-group col-md-6">
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
	a:'cat',
	load:function(_,F,f,e,o,i){
		e = f.idc;
		o = e.options;
		$.each(_.cat,function(key, val){
			recursiveFunction(key, val)
		});
		function recursiveFunction(key, val) {
			actualFunction(key, val);
			var value = val['children'];
			if (value instanceof Object) {
				$.each(value, function(key, val) {
					recursiveFunction(key, val)
				});
			}
		}
		function actualFunction(key, val) {
			var level = val['level']*5;
			tab = "";
			if(level)for(i=1; i<=level;i++)tab += "\u00a0";

			if(key>0)o[i=o.length] = new Option(val['n'].replace('=>',tab),key);
			else o[i=o.length] = new Option(val[0],key);
			if(key==_.idc)e.selectedIndex = i;
		}
	}
});
</script>
<script type="text/javascript">
$.extend(true,adm,<?=json_encode($a)?>);
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
		['insert', ['link', 'picture', 'hr']],
		['view', ['fullscreen', 'codeview']],
		['help', ['help']]
	],
	onpaste : function (e)  {
		var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
        e.preventDefault();
        document.execCommand('insertText', false, bufferText);
    },
	onImageUpload: function(files, editor, welEditable) {
		sendFile(files[0], editor, welEditable);
	}
});
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
		url:'ajax/i/categoria.json',
		cache: false,
		contentType: false,
		processData: false,
		success: function(x){
			editor.insertImage(welEditable, x.url);
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