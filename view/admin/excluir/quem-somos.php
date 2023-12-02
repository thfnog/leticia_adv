<div class="col-md-12">
	<div class="panel panel-white">
		<div class="panel-heading clearfix">
			<h4 class="panel-title">Alterar <?=$rs->h1?></h4>
		</div>
		<div class="panel-body">
			<form id="id-form">
				<div class="form-group col-md-12">
					<label for="h1">* Título</label>
					<input type="text" class="form-control" id="h1" name="h1" placeholder="Digite o título (h1)" value="<?=strh($rs->h1)?>">
				</div>
				<div class="form-group col-md-12">
					<label class="control-label" for="d">* Descrição</label>
					<div>
						<progress style="display:none;margin-bottom:10px;width:100%"></progress>
						<textarea class="summernote" id="d" name="d"><?=strh($rs->d)?></textarea>
					</div>
				</div>
<?
if($s->id){
	$sfotos = $b->query("select * from fotos where idp='{$s->id}' and tipo='quem-somos'");
	if($sfotos->rowCount()){
		while($rfotos=$sfotos->fetchObject()){
?>
				<div class="form-group col-xs-12 col-lg-3">
					<label for="principal-<?=$rfotos->id?>" class="text-center">
						<img src="upload/quem-somos/<?=$rfotos->it?>" class="view-imgs"/>
						<input type="radio" id="principal-<?=$rfotos->id?>" name="principal" value="<?=$rfotos->id?>" <?=$rfotos->principal?'checked':''?>/>
						IMAGEM PRINCIPAL
					</label>
					<?php /*?><label for="hover-<?=$rfotos->id?>" class="text-center">
						<input type="radio" id="hover-<?=$rfotos->id?>" name="hover" value="<?=$rfotos->id?>" <?=$rfotos->hover?'checked':''?>/>
						IMAGEM HOVER
					</label><?php */?>
				</div>
<?
		}
?>
				<div class="clearfix"></div>
				<div class="form-group col-xs-12 col-lg-3">
					<a href="admin/quem-somos-foto/<?=$s->id?>" class="btn btn-danger">REMOVER FOTOS</a>
				</div>
<?
	}else echo '<div class="form-group col-xs-12 col-lg-3"><a href="admin/quem-somos-foto/'.$s->id.'" class="btn btn-success">ADICIONAR FOTOS</a></div>';
?>
<?
}
?>
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
<script type="text/javascript">
var adm = $.form({
	a:'quem-somos',
	load:function(_,F,f,e,o,i){}
});
</script>
<script type="text/javascript">
$.extend(adm,<?=json_encode($a)?>);
</script>
<?
echo $s->summernote();
Inline::b();
?>