<div class="col-md-12">
	<div class="panel panel-white">
		<div class="panel-heading clearfix">
			<h4 class="panel-title"><?=$s->id?'Alterar':'Novo'?> Slider</h4>
		</div>
		<div class="panel-body">
			<form id="id-form">
				<?php /*?><div class="form-group col-md-12">
					<label for="tipo">* Tipo do slider</label>
					<select class="form-control" name="tipo" id="tipo"></select>
				</div><?php */?>
				<div class="form-group col-md-6 col-xs-12">
					<label for="n">Título</label>
					<input type="text" class="form-control" id="n" name="n" placeholder="Digite o título" value="<?=strh($rs->n)?>">
				</div>
                <div class="form-group col-md-6 col-xs-12">
                    <label for="cor_n">Cor do Título</label>
                    <input class="form-control color {hash:true,caps:false}" id="cor_n" name="cor_n" value="<?=$rs->cor_n?strh($rs->cor_n):'#fff'?>">
                </div>
                <div class="form-group col-md-6 col-xs-12">
					<label for="n2">Subtítulo</label>
					<input type="text" class="form-control" id="n2" name="n2" placeholder="Digite o subtítulo" value="<?=strh($rs->n2)?>">
				</div>
                <div class="form-group col-md-6 col-xs-12">
                    <label for="cor_n2">Cor do Subtítulo</label>
                    <input class="form-control color {hash:true,caps:false}" id="cor_n2" name="cor_n2" value="<?=$rs->cor_n2?strh($rs->cor_n2):'#fff'?>">
                </div>
				<div class="form-group col-md-4 col-xs-12">
					<label for="l">Link</label>
					<input type="text" class="form-control" id="l" name="l" placeholder="Digite ou cole o link" value="<?=strh($rs->l)?>">
				</div>
                <div class="form-group col-md-4 col-xs-12">
                    <label for="background_l">Background Botão</label>
                    <input class="form-control color {hash:true,caps:false}" id="background_l" name="background_l" value="<?=$rs->background_l?strh($rs->background_l):'#ff6aad'?>">
                </div>
                <div class="form-group col-md-4 col-xs-12">
                    <label for="cor_l">Cor do Texto do Botão</label>
                    <input class="form-control color {hash:true,caps:false}" id="cor_l" name="cor_l" value="<?=$rs->cor_l?strh($rs->cor_l):'#fff'?>">
                </div>
				<div class="imagem">
					<div class="clearfix"></div>
					<div class="form-group col-md-12">
						<label for="i">* Imagem:</label>
						<input type="file" name="i" class="txt left mr"/>
						<div class="text left ml"><span><strong>Largura:</strong> 1920px</span><span><strong>Altura:</strong> 1080px</span></div>
						<div class="clearfix"></div>
						<div id="img-view-i" class="img-view col-sm-6" cls="top">
							<?php /*?><label class="top">Remover Imagem:<input type="checkbox" name="ri" value="1" class="ckb"/></label><?php */?>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="form-group col-md-12">
						<label for="ie">* Imagem Elemento:</label>
						<input type="file" name="ie" class="txt left mr"/>
						<div class="text left ml"><span><strong>Largura:</strong> 1920px</span><span><strong>Altura:</strong> 1080px - (PNG com fundo transparente)</span></div>
						<div class="clearfix"></div>
						<div id="img-view-ie" class="img-view col-sm-6" cls="top">
							<label class="top">Remover Imagem:<input type="checkbox" name="rie" value="1" class="ckb"/></label>
						</div>
					</div>
				</div>
				<div class="video">
					<div class="form-group col-md-12">
						<label for="y">ID do YouTube</label>
						<input type="text" class="form-control" id="y" name="y" placeholder="Digite somente o ID do YouTube ou cole a URL aqui" value="<?=strh($rs->y)?>">
						<div id="ytb-view-y" style="margin-top:10px"></div>
					</div>
				</div>
				<div class="clearfix"></div>
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
<link href="assets/css/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="assets/js/admin/select2.min.js"></script>
<script type="text/javascript" src="assets/js/jscolor/jscolor.js"></script>
<script type="text/javascript">
var adm = $.form({
	a:'slider',
	y:{y:''},
	cgT:function(h){
		//var _ = this,f = _.f,tipo = $(this.f.tipo).val();
		var tipo = 'imagem';
		$('.imagem')[tipo=='imagem'?'show':'hide']();
		$('.video')[tipo=='video'?'show':'hide']();
	},
	load:function(_,F,f,e,o,i){
		/*e = f.tipo;
		o = e.options;
		$.each(_.tp,function(i,v){
			o[i=o.length] = new Option(v[0],v[1]);
			if(v[1]==_.tipo)e.selectedIndex = i;
		});
		$(e).change(function(){
			_.cgT();
		});
		_.cgT(0);*/
		_.cgT(0);
	},
	tp:[['-- Selecione o Tipo de Slider --',0],['Imagem','imagem'],['Vídeo','video']]
});
</script>
<script type="text/javascript">
$.extend(adm,<?=json_encode($a)?>);
</script>
<?
Inline::b();
?>