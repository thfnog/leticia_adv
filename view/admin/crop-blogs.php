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
$sf = $b->query("select * from fotos where idp='{$s->id}' and tipo='blog'");
if($sf->rowCount()){
	$largura_interno = 880;
	$altura_interno = 440;
	$largura_thumb = 278;
	$altura_thumb = 139;
	$largura_ultimos = 160;
	$altura_ultimos = 80;
	while($rf=$sf->fetchObject()){
?>
			<tr class="lrow img even">
				<td class="cell box-img" title="<?=$rs->n?>">
					<span class="box-img-center load auto w"><span></span><img src="upload/blogs/<?=$rf->i?>"></span>
				</td>
				<td class="cell line" title="<?=$rs->n?>">Recortar Imagem</td>
				<td class="cell">
					<a class="ico <?=$rf->it?'icropped':'icrop'?>" title="Recortar Imagem" href="admin/crop/fotos-<?=$largura_thumb.'-'.$altura_thumb?>-blogs-thumb-i-it/<?=$rf->id?>"></a>
				</td>
			</tr>
			<tr class="lrow img even">
				<td class="cell box-img" title="<?=$rs->n?>">
					<span class="box-img-center load auto w"><span></span><img src="upload/blogs/<?=$rf->i?>"></span>
				</td>
				<td class="cell line" title="<?=$rs->n?>">Recortar Imagem Interno</td>
				<td class="cell">
					<a class="ico <?=$rf->iti?'icropped':'icrop'?>" title="Recortar Imagem Interno" href="admin/crop/fotos-<?=$largura_interno.'-'.$altura_interno?>-blogs-thumb-i-iti/<?=$rf->id?>"></a>
				</td>
			</tr>
			<tr class="lrow img even">
				<td class="cell box-img" title="<?=$rs->n?>">
					<span class="box-img-center load auto w"><span></span><img src="upload/blogs/<?=$rf->i?>"></span>
				</td>
				<td class="cell line" title="<?=$rs->n?>">Recortar Imagem Últimos</td>
				<td class="cell">
					<a class="ico <?=$rf->iti?'icropped':'icrop'?>" title="Recortar Imagem Últimos" href="admin/crop/fotos-<?=$largura_ultimos.'-'.$altura_ultimos?>-blogs-thumb-i-itu/<?=$rf->id?>"></a>
				</td>
			</tr>
<?
	}
}
?>
		</tbody>
	</table><br/>
	<a href="admin/blogs" class="btn btn-danger">Voltar</a>
</div>