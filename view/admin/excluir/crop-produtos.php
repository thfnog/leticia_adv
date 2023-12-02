<div id="table-0" class="tabela2 col-lg-12 col-md-12">
	<table class="display table dataTable">
		<thead>
			<tr class="lrow th">
				<th class="cell"><a href="javascript:;">Imagem</a></th>
				<th class="cell"><a href="javascript:;">Título</a></th>
				<th class="cell"><a href="javascript:;">Recortar</a></th>
			</tr>
		</thead>
		<tbody class="tab-lista">
<?
$sf = $b->query("select * from fotos where idp='{$s->id}' and tipo='produto'");
if($sf->rowCount()){
	while($rf=$sf->fetchObject()){
?>
			<tr class="lrow img even">
				<td class="cell box-img" title="<?=$rs->n?>">
					<span class="box-img-center load auto w"><span></span><img src="upload/produtos/<?=$rf->i?>"></span>
				</td>
				<td class="cell line" title="<?=$rs->n?>">Recortar Imagem</td>
				<td class="cell">
					<a class="ico <?=$rf->it?'icropped':'icrop'?>" title="Recortar Imagem" href="admin/crop/fotos-400-400-produtos-thumb-i-it/<?=$rf->id?>"></a>
				</td>
			</tr>
			<tr class="lrow img even">
				<td class="cell box-img" title="<?=$rs->n?>">
					<span class="box-img-center load auto w"><span></span><img src="upload/produtos/<?=$rf->i?>"></span>
				</td>
				<td class="cell line" title="<?=$rs->n?>">Recortar Imagem Carrinho</td>
				<td class="cell">
					<a class="ico <?=$rf->itc?'icropped':'icrop'?>" title="Recortar Imagem Carrinho" href="admin/crop/fotos-85-85-produtos-thumb-i-itc/<?=$rf->id?>"></a>
				</td>
			</tr>
			<?php /*?><tr class="lrow img even">
				<td class="cell box-img" title="<?=$rs->n?>">
					<span class="box-img-center load auto w"><span></span><img src="upload/produtos/<?=$rf->i?>"></span>
				</td>
				<td class="cell line" title="<?=$rs->n?>">Recortar Imagem Home</td>
				<td class="cell">
					<a class="ico <?=$rf->ith?'icropped':'icrop'?>" title="Recortar Imagem Home" href="admin/crop/fotos-265-265-produtos-thumb-i-ith/<?=$rf->id?>"></a>
				</td>
			</tr><?php */?>
			<tr class="lrow img even">
				<td class="cell box-img" title="<?=$rs->n?>">
					<span class="box-img-center load auto w"><span></span><img src="upload/produtos/<?=$rf->i?>"></span>
				</td>
				<td class="cell line" title="<?=$rs->n?>">Recortar Imagem Interno</td>
				<td class="cell">
					<a class="ico <?=$rf->iti?'icropped':'icrop'?>" title="Recortar Imagem Interno" href="admin/crop/fotos-760-760-produtos-thumb-i-iti/<?=$rf->id?>"></a>
				</td>
			</tr>
			<tr class="lrow img even">
				<td class="cell box-img" title="<?=$rs->n?>">
					<span class="box-img-center load auto w"><span></span><img src="upload/produtos/<?=$rf->i?>"></span>
				</td>
				<td class="cell line" title="<?=$rs->n?>">Recortar Imagem Miniatura</td>
				<td class="cell">
					<a class="ico <?=$rf->itm?'icropped':'icrop'?>" title="Recortar Imagem Miniatura" href="admin/crop/fotos-100-100-produtos-thumb-i-itm/<?=$rf->id?>"></a>
				</td>
			</tr>
			<?php /*?><tr class="lrow img even">
				<td class="cell box-img" title="<?=$rs->n?>">
					<span class="box-img-center load auto w"><span></span><img src="upload/produtos/<?=$rf->i?>"></span>
				</td>
				<td class="cell line" title="<?=$rs->n?>">Recortar Imagem Relacionado</td>
				<td class="cell">
					<a class="ico <?=$rf->itr?'icropped':'icrop'?>" title="Recortar Imagem Relacionado" href="admin/crop/fotos-265-265-produtos-thumb-i-itr/<?=$rf->id?>"></a>
				</td>
			</tr><?php */?>
<?
	}
}
?>
		</tbody>
	</table><br/>
	<a href="admin/produtos" class="btn btn-danger">Voltar</a>
</div>
<?
Inline::a();
?>
<script type="text/javascript">
/*$(".icrop").each(function(){
	var url = $(this).attr('href');
	window.open(url);
});*/
</script>
<?
Inline::b();
?>