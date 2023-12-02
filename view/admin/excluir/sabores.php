<div id="table-0" class="tabela2 col-lg-12 col-md-12">
	<div class="panel panel-white">
		<div class="panel-heading">
			<form id="id-form-filtro" onsubmit="return adm.busca();">
				<div class="lrow tab">
					<div class="cell">
						<select name="qt" title="Exibir" class="form-control"></select>
					</div>
					<div class="cell itxt">
						<input type="text" name="q" class="filtro-q form-control"/>
					</div>
					<div class="checker" style="margin-top:8px"><span><input type="checkbox" name="rel" value="1" title="Pesquisa com Relevâcia"></span></div>
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
				</div>
			</div>
		</div>
	</div>
</div>
<?
Inline::a();
?>
<script type="text/javascript">
var ft = {}

$(function(){
	var _ = ft,f = $('#id-form-filtro')[0],e,o,i=0,k;
	_.f = f;

	e = f.qt;
	o = e.options;
	$.each(_.qt,function(i,v){
		o[i=o.length] = new Option(v,v);
		if(_.view==v)e.selectedIndex = i;
	});
});

var adm = $.tab({
	c:{a:'sabor',mt:'este Sabor',ma:'Novo Sabor',add:'admin/sabor/',fn:function(){
		return $(ft.f).serializeObject();
	}},
	e:'#table-0',
	v:'Nenhum Sabor',
	l:'Buscando...',
	img:0,
	ajax:1,
	debugBusca:0,
	debugBuscaText:0,
	debugBuscaXML:0,
	o:'dc desc',
	oi:['id','dc','da','s','t','d','i','it','q'],
	th:[
		{n:'Título',w:250,o:'t',tt:'n',l:1,a:'admin/sabor/',c:'id',tb:0},
		{n:'Cadastrado em',w:130,o:'dc',tt:'_dc'},
		{n:'Alterado em',w:130,o:'da',tt:'_da'},
		{t:1,n:'Opções',w:90,o:'s,t',bt:'opt'}
	]
});
ft.view = 10;
ft.qt = [10,15,20,30,50,60,100];
</script>
<script type="text/javascript">
$.extend(ft,<?=json_encode($a)?>);
</script>
<?
Inline::b();
?>