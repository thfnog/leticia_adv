<style>
.panel-body .mb8{border-bottom:solid 1px #ebebeb;padding-bottom:8px}
</style>
<?
if($s->id){
?>
<div class="tabela2 row">
	<div class="panel panel-white" style="background:transparent">
		<div class="panel-body pedido">
<?
	if($rc=$b->query("select * from cliente where id={$rs->idu} limit 1")->fetchObject()){
		$sexo = array('','Masculino','Feminino');
?>
			<div class="tabela2 col-lg-6 col-md-12">
				<div class="panel panel-info">
					<div class="panel-heading" style="height:auto"><h3 class="panel-title uppercase">Dados do Cliente</h3></div>
					<div class="panel-body" style="margin-top:15px">
						<div class="uppercase mb8"><strong>Nome:</strong> <?=strh($rc->n)?></div>
						<div class="uppercase mb8"><strong>E-mail:</strong> <?=strh($rc->email)?></div>
						<div class="uppercase mb8"><strong>Cadastrado em:</strong> <?=$rc->dc?datef($rc->dc,11):''?></div>
						<div class="uppercase mb8"><strong>Modificado em:</strong> <?=$rc->da?datef($rc->da,11):''?></div>
						<div class="uppercase mb8"><strong>Tipo de Cadastro:</strong> Pessoa <?=$rc->t==2?'Jurídica':'Física'?></div>
						<!--<div class="uppercase mb8"><strong>Sexo:</strong> <?=$sexo[$rc->sx]?></div>-->
						<div class="uppercase mb8"><strong>Data de Nascimento:</strong> <?=$rc->dn?datef($rc->dn,8):''?></div>
						<div class="uppercase mb8"><strong>CPF:</strong> <?=strh($rc->cpf)?></div>
						<?php /*?><div class="uppercase mb8"><strong>RG:</strong> <?=strh($rc->rg)?></div><?php */?>
<?
		if($rc->tp==2){
?>
						<div class="uppercase mb8"><strong>Razão Social:</strong> <?=strh($rc->r)?></div>
						<div class="uppercase mb8"><strong>Nome Fantasia:</strong> <?=strh($rc->nf)?></div>
						<div class="uppercase mb8"><strong>CNPJ:</strong> <?=strh($rc->cnpj)?></div>
						<div class="uppercase mb8"><strong>Inscrição Estadual (IE):</strong> <?=strh($rc->ie)?></div>
						<div class="uppercase mb8"><strong>Inscrição Municipal (IM):</strong> <?=strh($rc->im)?></div>
<?
		}
?>

						<div class="uppercase mb8"><strong>Telefone 1:</strong> <?=strh($rc->t1)?></div>
						<div class="uppercase mb8"><strong>Telefone 2:</strong> <?=strh($rc->t2)?></div>

					</div>
				</div>
			</div>
			<div class="tabela2 col-lg-6 col-md-12">
				<div class="panel panel-info">
					<div class="panel-heading" style="height:auto"><h3 class="panel-title uppercase">Endereço de Entrega</h3></div>
					<div class="panel-body" style="margin-top:15px">
						<div class="uppercase mb8"><strong>CEP:</strong> <?=strh($rs->cep?$rs->cep:$rc->cep)?></div>
						<div class="uppercase mb8"><strong>Endereço:</strong> <?=strh($rs->rua?$rs->rua.($rs->num?', '.$rs->num:''):$rc->rua.($rc->num?', '.$rc->num:''))?></div>
						<div class="uppercase mb8"><strong>Complemento:</strong> <?=strh($rs->comp?$rs->comp:$rc->comp)?></div>
						<div class="uppercase mb8"><strong>Bairro:</strong> <?=strh($rs->bairro?$rs->bairro:$rc->bairro)?></div>
						<div class="uppercase mb8"><strong>Cidade:</strong> <?=strh($rs->city?$rs->city.' - '.$rs->uf:$rc->city.' - '.$rc->uf)?></div>
					</div>
				</div>
				<div class="clearfix"></div>
				
			</div>
<?
	}
?>

			<div class="clearfix"></div>
			<div class="tabela2 col-lg-12 col-md-12">
				<div class="panel panel-info">
					<div class="panel-heading" style="height:auto"><h3 class="panel-title uppercase">Itens do Pedido</h3></div>
					<div class="table-responsive project-stats">
						<!--<table id="table-0" class="display table dataTable">
							<thead><tr class="lrow th"></tr></thead>
							<tbody class="tab-lista"></tbody>
							<tbody class="lrow void"></tbody>
							<tbody class="lrow loading"></tbody>
							<thead><tr class="lrow th"></tr></thead>
						</table>-->
						<table id="table-0a" class="display table dataTable">
							<thead>
								<tr class="lrow th">
									<th class="cell null"><a>Imagem</a></th>
									<!--<th class="cell c"><a>Código</a></th>-->
									<th class="cell pt"><a>Produto</a></th>
									<th class="cell sku"><a>SKU TID</a></th>
									<th class="cell v"><a>Preço Unit.</a></th>
									<th class="cell q"><a>Qtde</a></th>
									<th class="cell t"><a>Total</a></th>
								</tr>
							</thead>
							<tbody class="tab-lista">
<?
	$sp = $b->query("select a.*,p.h1 n,p.t pt,f.itc,p.c,p.sku from cart_ax a left join produto p on a.idp=p.id left join cart c on a.idc=c.id left join fotos f on p.id=f.idp and f.tipo='produto' and f.principal where a.idc='{$s->id}'");
	while($rp=$sp->fetchObject()){
?>
								<tr class="lrow img odd" _id="<?=$rp->id?>">
									<td class="cell box-img"><span class="box-img-center load auto w"><span></span><img src="upload/produtos/thumb/<?=$rp->itc?$rp->itc:'default.jpg'?>"></span></td>
									<!--<td class="cell line" title="<?=$rp->c?>"><?=$rp->c?></td>-->
									<td class="cell line" title="<?=$rp->n?>"><?=$rp->n?></td>
									<td class="cell line" title="<?=$rp->sku?>"><?=$rp->sku?></td>
									<td class="cell"><?='R$ '.nreal($rp->v)?></td>
									<td class="cell"><?=$rp->q?></td>
									<td class="cell"><?='R$ '.nreal($rp->t)?></td>
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
									<th class="cell null"><a>Imagem</a></th>
									<!--<th class="cell c"><a>Código</a></th>-->
									<th class="cell pt"><a>Produto</a></th>
									<th class="cell sku"><a>SKU TID</a></th>
									<th class="cell v"><a>Preço Unit.</a></th>
									<th class="cell q"><a>Qtde</a></th>
									<th class="cell t"><a>Total</a></th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
<?
}
?>
		</div>
	</div>
</div>
<?php
Inline::a();
?>
<script type="text/javascript">
var adm = {l:0,
	go:function(){
		var e = $('#idq'),s = $('#ids'),v = parseInt($.trim(e.val()),10);
		s.addClass('load2');
		if(v>0&&v!=this.id)setTimeout(function(){location = 'admin/pedido/'+v;},100);
		else s.removeClass('load2');
		return false;
	},
<?
if($rs->forma=='pagseguro'){
?>
	set:function(){
		var _ = this,statusPagseguro = _.statusPagseguro,statusPedido = _.statusPedido,/*k = [p],*/e,o;
		/*if(p==2)k = [2,3];
		if(p==3||p==4)k = [2,3,4];
		if(p==4&&s==2)k.push(5);
		if(p==5)k = [5,6,7];*/

		e = _.es[0];
		o = e.options;
		o.length = 0;
		$.each([1,2,3,4,5,6,7],function(i,v){
			o[o.length] = new Option(ps.stt[v],v);
		});
		$('.statusPagseguro').text(ps.stt[statusPagseguro]);
		_.es.val(statusPagseguro);

		e = _.ep[0];
		o = e.options;
		o.length = 0;
		//$.each(k,function(i,v){
		$.each([1,2,3,4,5,6,7,8,9,10],function(i,v){
			o[o.length] = new Option(ps.sttPedido[v],v);
		});
		$('.statusPedido').text(ps.sttPedido[statusPedido]);
		_.ep.val(statusPedido);

		$('.da').text(_.da);
	},
	cgPagamento:function(){
		var _ = this,es = _.es,e = es,statusPagseguro = parseInt(es.val());
		if(!statusPagseguro)es.val(statusPagseguro=_.statusPagseguro);
		if((statusPagseguro==_.statusPagseguro)||_.l)return false;
		_.l = 1;
		e.attr('disabled',true);
		$.post('ajax/u/status-pagamento.json',{id:_.id,statusPagseguro:statusPagseguro},function(x){
			if($.isNumeric(x.statusPagseguro))_.statusPagseguro = x.statusPagseguro;
			if(x.da!=null)_.da = x.da;
			if(x.m)alert(x.m);
		},'json').complete(function(){
			_.l = 0;
			e.attr('disabled',false);
			_.set();
		});
	},
	cgPedido:function(){
		var _ = this,ep = _.ep,e = ep,statusPedido = parseInt(ep.val());
		if(!statusPedido)ep.val(statusPedido=_.statusPedido);
		if((statusPedido==_.statusPedido)||_.l)return false;
		_.l = 1;
		e.attr('disabled',true);
		$.post('ajax/u/status-pedido.json',{id:_.id,statusPedido:statusPedido},function(x){
			if($.isNumeric(x.statusPedido))_.statusPedido = x.statusPedido;
			if(x.da!=null)_.da = x.da;
			if(x.m)alert(x.m);
		},'json').complete(function(){
			_.l = 0;
			e.attr('disabled',false);
			_.set();
			location.reload();
		});
	},
<?
}else{
	if($s->tipoAdm==1){
?>
	set:function(){
		//var _ = this,statusPagseguro = _.statusPagseguro,statusPedido = _.statusPedido,e,o;
		var _ = this,statusPedido = _.statusPedido,e,o;

		e = _.ep[0];
		o = e.options;
		o.length = 0;
		$.each([1,2,3,4,5,6,7,8,9,10],function(i,v){
			o[o.length] = new Option(ps.sttPedido[v],v);
		});
		$('.statusPedido').text(ps.sttPedido[statusPedido]);
		_.ep.val(statusPedido);

		$('.da').text(_.da);
	},
	/*set:function(){
		var _ = this,statusPagseguro = _.statusPagseguro,statusPedido = _.statusPedido,e,o;

		e = _.es[0];
		o = e.options;
		o.length = 0;
		$.each([1,2,3,4,5,6,7],function(i,v){
			o[o.length] = new Option(ps.stt[v],v);
		});
		$('.statusPagseguro').text(ps.stt[statusPagseguro]);
		_.es.val(statusPagseguro);

		e = _.ep[0];
		o = e.options;
		o.length = 0;
		$.each([1,2,3,4,5,6,7,8],function(i,v){
			o[o.length] = new Option(ps.sttPedido[v],v);
		});
		$('.statusPedido').text(ps.sttPedido[statusPedido]);
		_.ep.val(statusPedido);

		$('.da').text(_.da);
	},
	cgPagamento:function(){
		var _ = this,es = _.es,e = es,statusPagseguro = parseInt(es.val());
		if(!statusPagseguro)es.val(statusPagseguro=_.statusPagseguro);
		if((statusPagseguro==_.statusPagseguro)||_.l)return false;
		_.l = 1;
		e.attr('disabled',true);
		$.post('ajax/u/status-pagamento.json',{id:_.id,statusPagseguro:statusPagseguro},function(x){
			if($.isNumeric(x.statusPagseguro))_.statusPagseguro = x.statusPagseguro;
			if(x.da!=null)_.da = x.da;
			if(x.m)alert(x.m);
		},'json').complete(function(){
			_.l = 0;
			e.attr('disabled',false);
			_.set();
		});
	},*/
	cgPedido:function(){
		var _ = this,ep = _.ep,e = ep,statusPedido = parseInt(ep.val());
		if(!statusPedido)ep.val(statusPedido=_.statusPedido);
		if((statusPedido==_.statusPedido)||_.l)return false;
		_.l = 1;
		e.attr('disabled',true);
		$.post('ajax/u/status-pedido.json',{id:_.id,statusPedido:statusPedido},function(x){
			if($.isNumeric(x.statusPedido))_.statusPedido = x.statusPedido;
			if(x.da!=null)_.da = x.da;
			if(x.m)alert(x.m);
		},'json').complete(function(){
			_.l = 0;
			e.attr('disabled',false);
			_.set();
			location.reload();
		});
	},
<?
	}
}
?>
};
adm.id = <?=$s->id?>;

$.extend(true,adm,<?=json_encode($a)?>);

$(function(){
	var _ = adm,es = $('#id-set-s'),ep = $('#id-set-p');
	_.es = es;
	_.ep = ep;
	es.change(function(){
		_.cgPagamento();
	});
	ep.change(function(){
		_.cgPedido();
	});
<?
if($s->tipoAdm==1){
?>
	_.set();
<?
}
?>
});

$(function(){
	var _ = adm;
	$('#codigo').click(function(){
		var c = $('.codigo').val();
		$.post('ajax/u/codigo.json',{id:_.id,c:c},function(x){
			if(x.m)alert(x.m);
		},'json').complete(function(){
			$('#codigo').val('ALTERAR CÓDIGO');
		});
	});
});
var ps = <?=json_encode($s->ps)?>;

$(document).on('click','.excluir-etiqueta',function(){
	var confirmar = confirm("Você tem certeza que deseja excluir a etiqueta?");
	if(confirmar==true){
		$.post('ajax/d/etiqueta.json',{id:<?=$s->id?>},function(){
		},'json').success(function(x){
			if(x.m)alert(x.m);
			if(x.l)window.location = x.l;
		});
	}else{
		return false;
	}
});
</script>
<?php
Inline::b();
?>