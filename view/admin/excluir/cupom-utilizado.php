<div class="col-md-12">
	<div class="panel panel-white">
		<div class="panel-heading clearfix"<?=!$rs->s?' style="height:75px"':''?>>
			<h4 class="panel-title">CUPOM <?=$rs->n?></h4>
<?
if(!$rs->s){
?>
			<h2 class="panel-title pull-right" style="text-transform:uppercase;color:#f00;font-size:35px">Produto Inativo</h2>
<?
}
?>
		</div>
		<div class="panel-body">
			<form id="id-form" name="cadastro">
				<div class="tab-content">
<?
if($s->id){
//$su = $b->query("select c.data dp,c.nome_destinatario n,razao_social r,nome nome,c.status s,l.mail email,l.ddd_cel ddd1,l.fone_cel t1,l.ddd ddd2,l.fone t2,c.valor_total v,d.quantidade q,d.ID_PEDIDO idp from PEDIDOS_DETALHE d left join PEDIDOS_CABECALHO c on d.id_pedido=c.id_pedido left join CLIENTES l on c.id_cliente=l.id_cliente where d.id_empresa={$s->ide} and c.idd='{$s->id}' group by c.id_pedido order by c.data desc");
$su = $b->query("select p.dc dp,c.n,c.r,p.statusPedido,c.email,c.t1,p.t,p.id idp from pedido p left join cliente c on p.idu=c.id where p.idd='{$s->id}' group by p.id order by p.dc desc");
if(!$su->rowCount())echo '<strong>Nenhum pedido realizado</strong>';
else{
?>
					<table id="table-0a" class="display table dataTable">
						<thead>
							<tr class="lrow th">
								<th class="cell"><a>DATA</a></th>
								<th class="cell"><a>PEDIDO</a></th>
								<th class="cell"><a>CLIENTE</a></th>
								<!--<th class="cell"><a>QTD</a></th>-->
								<th class="cell"><a>STATUS</a></th>
								<th class="cell"><a>E-MAIL</a></th>
								<th class="cell"><a>CELULAR</a></th>
								<!--<th class="cell"><a>TELEFONE</a></th>-->
								<th class="cell"><a>VALOR</a></th>
							</tr>
						</thead>
						<tbody class="tab-lista">
<?
$j = 0;
while($ru=$su->fetchObject()){
	$j++;
	$status = $ru->s==4?'Finalizado':($ru->s==5?'Cancelado':'Não Pagou');
?>
							<tr class="lrow <?=$j%2==0?'even':'odd'?>" _id="<?=$ru->id?>">
								<td class="cell line" title="<?=datef($ru->dp,8)?>"><?=datef($ru->dp,8)?></td>
								<td class="cell line" title="<?=$ru->idp?>"><a href="admin/pedido/<?=$ru->idp?>" target="_blank"><?=$ru->idp?></a></td>
								<td class="cell line" title="<?=$ru->n?$ru->n:$ru->r?>"><?=$ru->n?$ru->n:$ru->r?></td>
								<!--<td class="cell line" title="<?=$ru->q?>"><?=$ru->q?></td>-->
								<td class="cell line" title="<?=$s->ps->sttPedido[$ru->statusPedido+0]?>"><?=$s->ps->sttPedido[$ru->statusPedido+0]?></td>
								<td class="cell line" title="<?=$ru->t1?>"><?=$ru->t1?></td>
								<td class="cell line" title="<?=$ru->email?>"><?=$ru->email?></td>
								<!--<td class="cell line" title="<?=$ru->ddd2&&$ru->t2?'('.$ru->ddd2.') '.$ru->t2:''?>"><?=$ru->ddd2&&$ru->t2?'('.$ru->ddd2.') '.$ru->t2:''?></td>-->
								<td class="cell line" title="<?='R$ '.nreal($ru->t)?>"><?='R$ '.nreal($ru->t)?></td>
							</tr>
<?
}
?>
						</tbody>
						<tbody class="lrow void" style="display: none;">
						<td class="cell">Nenhum Item</td>
							</tbody>
						<tbody class="lrow loading" style="display: none;">
						</tbody>
						<thead>
							<tr class="lrow th">
								<th class="cell"><a>DATA</a></th>
								<th class="cell"><a>PEDIDO</a></th>
								<th class="cell"><a>CLIENTE</a></th>
								<!--<th class="cell"><a>QTD</a></th>-->
								<th class="cell"><a>STATUS</a></th>
								<th class="cell"><a>E-MAIL</a></th>
								<th class="cell"><a>CELULAR</a></th>
								<!--<th class="cell"><a>TELEFONE</a></th>-->
								<th class="cell"><a>VALOR</a></th>
							</tr>
						</thead>
					</table>
<?
}
}
?>
				</div>
			</form>
		</div>
	</div>
</div>