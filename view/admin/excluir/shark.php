<style>
.panel-body .mb8{border-bottom:solid 1px #ebebeb;padding-bottom:8px}
</style>
<div class="tabela2 row">
	<div class="panel panel-white" style="background:transparent">
		<div class="panel-body pedido">
			<div class="tabela2 col-lg-12 col-md-12">
				<div class="panel panel-info">
					<div class="panel-heading" style="height:auto"><h3 class="panel-title uppercase">Dados do Shark Team</h3></div>
					<div class="panel-body" style="margin-top:15px">
						<div class="uppercase mb8"><strong>Cadastrado em:</strong> <?=$rs->dc?datef($rs->dc,11):''?></div>
						<div class="uppercase mb8"><strong>Nome:</strong> <?=strh($rs->nome)?></div>
						<div class="uppercase mb8"><strong>E-mail:</strong> <?=strh($rs->email)?></div>
						<div class="uppercase mb8"><strong>Telefone:</strong> <?=strh($rs->telefone)?></div>
						<div class="uppercase mb8"><strong>Sexo:</strong> <?=strh($sexos[$rs->sexo])?></div>
						<div class="uppercase mb8"><strong>Cidade:</strong> <?=strh($cidade->nome.' / '.$cidade->uf)?></div>
						<div class="uppercase mb8"><strong>Redes Sociais:</strong> <?=strhb($rs->sociais)?></div>
						<div class="uppercase mb8"><strong>Segmento:</strong> <?=strh($rs->segmento==8?$rs->outro:$segmentos[$rs->segmento])?></div>
						<div class="uppercase mb8"><strong>Proposta:</strong> <?=strh($rs->proposta)?></div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>
<?
Inline::a();
?>
<?
Inline::b();
?>