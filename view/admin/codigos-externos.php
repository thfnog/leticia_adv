<div class="col-md-12">
	<div class="panel panel-white">
		<div class="panel-heading clearfix">
			<h4 class="panel-title">Alterar Códigos Externos</h4>
		</div>
		<div class="panel-body">
			<div id="rootwizard">
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#tab1" data-toggle="tab"><i class="fa fa-google m-r-xs"></i>Google</a></li>
					<li role="presentation"><a href="#tab2" data-toggle="tab"><i class="fa fa-facebook m-r-xs"></i>Facebook</a></li>
				</ul>
				<div class="progress progress-sm m-t-sm">
					<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
					</div>
				</div>
				<form id="id-form">
					<div class="tab-content">
						<div class="tab-pane active fade in" id="tab1">
							<div class="form-group col-md-12">
								<label for="ga">Google Analytics <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="EXEMPLO: UA-999999999-9"></i></label>
								<input type="text" class="form-control" id="ga" name="ga" placeholder="Digite ou cole o código do Google Analytics" value="<?=strh($rs->ga)?>">
							</div>
							<!-- <div class="form-group col-md-12">
								<label for="googleTagManager">Google Tag Manager <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="EXEMPLO: GTM-WWWWWWW"></i></label>
								<input type="text" class="form-control" id="googleTagManager" name="googleTagManager" placeholder="Digite ou cole o código do Google Tag Manager" value="<?=strh($rs->googleTagManager)?>">
							</div> -->
							<div class="form-group col-md-12">
								<label for="ad">Google Adwords <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="EXEMPLO: AW-999999999"></i></label>
								<input type="text" class="form-control" id="ad" name="ad" placeholder="Digite ou cole o código do Google Adwords" value="<?=strh($rs->ad)?>">
							</div>
							<div class="form-group col-md-12">
								<label for="adConversion">Google Adwords Conversion<i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="EXEMPLO: AW-999999999"></i></label>
								<input type="text" class="form-control" id="adConversion" name="adConversion" placeholder="Digite ou cole o código do Google Adwords Conversion que está depois da /" value="<?=strh($rs->adConversion)?>">
							</div>
						</div>
						<div class="tab-pane fade" id="tab2">
							<div class="form-group col-md-12">
								<label for="pixelFacebook">Pixel Facebook Geral (Todas as Páginas) <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="EXEMPLO: 999999999999999"></i></label>
								<input type="text" class="form-control" id="pixelFacebook" name="pixelFacebook" placeholder="Digite ou cole o código do Pixel Facebook" value="<?=strh($rs->pixelFacebook)?>">
							</div>
							<div class="form-group col-md-12">
								<label for="pixelFacebookObrigado">Pixel Facebook Obrigado (Obrigado Checkout) <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="EXEMPLO: 999999999999999"></i></label>
								<input type="text" class="form-control" id="pixelFacebookObrigado" name="pixelFacebookObrigado" placeholder="Digite ou cole o código do Pixel Facebook" value="<?=strh($rs->pixelFacebookObrigado)?>">
							</div>
							<div class="form-group col-md-12">
								<label for="pixelFacebookContato">Pixel Facebook Obrigado (Obrigado Contato) <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="EXEMPLO: 999999999999999"></i></label>
								<input type="text" class="form-control" id="pixelFacebookContato" name="pixelFacebookContato" placeholder="Digite ou cole o código do Pixel Facebook" value="<?=strh($rs->pixelFacebookContato)?>">
							</div>
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
<script type="text/javascript" src="assets/js/admin/jquery.bootstrap.wizard.min.js"></script>
<script type="text/javascript">
var adm = $.form({
	a:'externo',
});
</script>
<script type="text/javascript">
$.extend(adm,<?=json_encode($a)?>);
</script>
<?
Inline::b();
?>