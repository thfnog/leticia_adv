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
if($rs->i){
?>
			<tr class="lrow img even">
				<td class="cell box-img" title="<?=$rs->n?>">
					<span class="box-img-center load auto w"><span></span><img src="upload/categorias/<?=$rs->i?>"></span>
				</td>
				<td class="cell line" title="<?=$rs->n?>">Recortar Imagem</td>
				<td class="cell">
					<a class="ico <?=$rs->it?'icropped':'icrop'?>" title="Recortar Imagem" href="admin/crop/cat-1920-300-categorias-thumb-i-it/<?=$rs->id?>"></a>
				</td>
			</tr>
<?
}if($rs->ih){
?>
			<tr class="lrow img even">
				<td class="cell box-img" title="<?=$rs->n?>">
					<span class="box-img-center load auto w"><span></span><img src="upload/categorias/<?=$rs->ih?>"></span>
				</td>
				<td class="cell line" title="<?=$rs->n?>">Recortar Imagem Home</td>
				<td class="cell">
					<a class="ico <?=$rs->ith?'icropped':'icrop'?>" title="Recortar Imagem Home" href="admin/crop/cat-120-180-categorias-thumb-ih-ith/<?=$rs->id?>"></a>
				</td>
			</tr>
<?
}
?>
		</tbody>
	</table><br/>
	<a href="admin/blogs" class="btn btn-danger">Voltar</a>
</div>