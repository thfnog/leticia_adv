<div id="table-0" class="tabela2 col-lg-12 col-md-12">
	<div class="panel panel-white">
		<div class="panel-heading">
			<form id="id-form-filtro" onsubmit="return adm.busca();">
				<div class="lrow tab">
					<div class="cell">
						<select name="qt" title="Exibir" class="form-control"></select>
					</div>
					<!--<div class="cell w180">
						<select name="s" class="form-control"></select>
					</div>-->
					<div class="cell w180">
						<select name="p" class="form-control"></select>
					</div>
					<div class="cell w180">
						<select name="tf" class="form-control"></select>
					</div>
					<!--<div class="cell w180">
						<select name="importado" class="form-control"></select>
					</div>-->
					<div class="cell itxt">
						<input type="text" name="q" class="filtro-q form-control" placeholder="Número do pedido"/>
					</div>
					<div class="cell right"><a class="filtro-bt"></a></div>
				</div>
			</form>
		</div>
		<div class="panel-body">
			<div class="table-responsive project-stats">
				<div class="lrow tab bold count">
					<div class="cell left"><span class="reg-encontrado"></span> registro(s)</div>
					<div class="cell left">Página <span class="pagina-atual"></span> de <span class="pagina-total"></span></div>
					<div class="cell paginacao-buts"></div>
					<div class="cell right"><a class="tab-add"></a></div>
					<div class="cell right"><!--<a class="tab-add"></a><span class="save-pos"></span>--></div>
				</div>
				
				<table class="display table dataTable">
					<thead><tr class="lrow th"></tr></thead>
					<tbody class="tab-lista"></tbody>
					<tbody class="lrow void"></tbody>
					<tbody class="lrow loading"></tbody>
					<thead><tr class="lrow th"></tr></thead>
				</table>
				
				<div class="lrow tab bold count">
					<div class="cell left"><span class="reg-encontrado"></span> registro(s)</div>
					<div class="cell left">Página <span class="pagina-atual"></span> de <span class="pagina-total"></span></div>
					<div class="cell paginacao-buts"></div>
					<div class="cell right"><a class="tab-add"></a></div>
					<div class="cell right"><!--<a class="tab-add"></a><span class="save-pos"></span>--></div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
Inline::a();
?>
<script type="text/javascript">
var ft = {}

$(function(){
	var _ = ft,f = $('#id-form-filtro')[0],e,o;
	_.f = f;

	e = f.qt;
	o = e.options;
	$.each(_.qt,function(i,v){
		o[i=o.length] = new Option(v,v);
		if(_.view==v)e.selectedIndex = i;
	});

	/*e = f.s;
	o = e.options;
	$.each(_.s,function(i,v,j){
		o[j=o.length] = new Option(v,i);
		if(_.vs==i)e.selectedIndex = j;
	});*/

	e = f.p;
	o = e.options;
	$.each(_.p,function(i,v,j){
		o[j=o.length] = new Option(v,i);
		if(_.vp==i)e.selectedIndex = j;
	});

	e = f.tf;
	o = e.options;
	$.each(_.tf,function(i,v,j){
		o[j=o.length] = new Option(v,i);
		if(_.vtf==i)e.selectedIndex = j;
	});

	/*e = f.importado;
	o = e.options;
	$.each(_.importado,function(i,v){
		o[i=o.length] = new Option(v[0],v[1]);
		if(v[1]==_.importado)e.selectedIndex = i;
	});*/
});

var adm = $.tab({
	c:{a:'pedido',mt:'este Pedido',ma:'Novo Pedido',add:'admin/pedido/',fn:function(){
		return $(ft.f).serializeObject();
	}},
	e:'#table-0',
	v:'Nenhum Pedido',
	l:'Buscando...',
	ajax:1,
	debugBusca:0,
	o:'dc desc',
	oi:['id','idu','a','statusPedido','dc','da','tf','v','i','n','importado','forma'],
	th:[
		{n:'ID',w:80,o:'id',a:'admin/pedido/',c:'id',tb:0},
		{n:'Cliente',w:150,o:'n',l:1},
		{n:'Data do Pedido',w:130,o:'dc desc',tt:'_dc'},
		//{n:'Status Pgto',w:155,o:'a,id desc',tt:'_a'},
		{n:'Forma Pgto',w:150,o:'forma',tt:'forma'},
		{n:'Status do Pedido',w:155,o:'statusPedido,id desc',tt:'_p'},
		//{n:'Valor',w:80,o:'v',tt:'_v'},
		{n:'Total',w:80,o:'t',tt:'_t'},
		{n:'Itens',w:50,o:'i,id desc'},
		//{n:'Importado na BL',w:155,o:'importado',tt:'_importado'},
		{t:1,n:'VER',w:80,o:'id',c:'id',tb:0,bt:[{tt:1,m:'cp',a:'admin/pedido/',i:['isearch'],t:['Ver Pedido']}]},
	]
});

ft.s = <?=json_encode($s->ps->stt)?>;
ft.p = <?=json_encode($s->ps->sttPedido)?>;
ft.tf = <?=json_encode($s->ps->envio)?>;

ft.s[0] = '-- Status do Pagseguro --';
ft.p[0] = '-- Status do Pedido --';
ft.tf[0] = '-- Método de Envio --';
//$.extend(ft,".json_encode($a).");
ft.view = 30;
ft.qt = [10,15,20,30,50,60,100];
//ft.importado = [['-- IMPORTADOS --',300],['NÃO',0],['SIM',1]];
</script>
<?php
Inline::b();
?>