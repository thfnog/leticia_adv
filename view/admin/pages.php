<?
if($s->cat){
?>
<div class="col-md-12">
	<div class="panel panel-white">
		<div class="panel-heading clearfix">
			<h4 class="panel-title">Alterar Meta Tags - <?=$s->admin->pages[$s->cat]?></h4>
		</div>
		<div class="panel-body">
			<form id="id-form">
				<input type="hidden" name="pg" value="<?=$s->cat?>"/>
				<div class="form-group col-md-12">
					<label for="tagt">Meta Title</label>
					<input type="text" class="form-control" id="tagt" name="t" placeholder="Digite a Meta Tag title" value="<?=strh($rs->t)?>">
				</div>
				<div class="form-group col-md-12">
					<label for="tagd">Meta Description</label>
					<textarea class="form-control" id="tagd" name="d" placeholder="Digite a Meta Tag description" rows="8"><?=strh($rs->d)?></textarea>
				</div>
				<div class="form-group col-md-12">
					<label for="h1">H1</label>
					<input type="text" class="form-control" id="h1" name="h1" placeholder="Digite o h1" value="<?=strh($rs->h1)?>">
				</div>
				<div class="clearfix"></div>
				<div class="container-seo form-group col-md-12">
					<div class="wrapper">
						<div class="main">
							<h3>PRÉVIA <i class="fa fa-question-circle" data-toggle="tooltip" title="" style="font-size:16px" data-original-title="Este é um exemplo de como este artigo pode aparecer nos resultados de busca do Google."></i></h3>
							<div class="title-seo">
								<span><?=strh($rs->t)?></span>
							</div>
							<div class="url-seo">
								<span><?=$s->base.$s->cat?></span>
							</div>
							<div class="description-seo">
								<span><?=strh($rs->d)?></span>
							</div>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="form-group col-md-12">
					<input type="submit" class="btn btn-success"/>
				</div>
				<div class="clearfix"></div>
			</form>
		</div>
	</div>
</div>
<?
}else{
?>
<?php /*?><script type="text/javascript">
var adm = $.tab({
	c:{add:'admin/pages/'},
	e:'#table-0',
	v:'',
	o:'i',
	oi:['id','i'],
	th:[
		{n:'#',w:50,o:'i'},
		{n:'Página',w:200,o:'id',l:1,tt:'n'},
		{t:1,n:'Opções',w:70,bt:['a']}
	]
});
</script>
<script type="text/javascript">
adm.rs = <?
$i = 0;
$_rs = array();
foreach($s->admin->pages as $k=>$v)$_rs[] = array('id'=>$k,'i'=>++$i,'n'=>$v);
echo json_encode($_rs);
?>;
</script><?php */?>
<div id="table-0" class="tabela2 col-lg-12 col-md-12">
	<div class="panel panel-white">
		<div class="panel-body">
			<div class="table-responsive project-stats">
				<table class="display table dataTable">
					<thead><tr class="lrow th"></tr></thead>
					<tbody class="tab-lista"></tbody>
					<tbody class="lrow void"></tbody>
					<tbody class="lrow loading"></tbody>
					<thead><tr class="lrow th"></tr></thead>
				</table>
			</div>
		</div>
	</div>
</div>
<?
}
?>