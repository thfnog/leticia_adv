<style>
.ui-sortable-helper{background:#fff !important;height:115px !important;display:table-row !important;border:solid 1px #ebebeb}
body .img .box-img-center,body .img .itxt input,body .img .itxt textarea{height:84px}
body .box-img{overflow:hidden;width:105px}
body .box-img-center{width:inherit;height:22px;border:1px solid #ddd}
body .box-img-center.w{background:#fff}
body .box-img-center.b{background:#000}
body .box-img-center.auto img{max-width:100%;max-height:100%}
.ui-sortable-helper td{display:block;float:left;padding:20px;margin-top:28px}
.ui-sortable-helper td.box-img{padding:20px 0 0 20px;margin-top:-5px}
.ui-sortable tr:nth-child(6n+1),.ui-sortable tr:nth-child(6n+2),.ui-sortable tr:nth-child(6n+3),.ui-sortable tr:nth-child(6n+4),.ui-sortable tr:nth-child(6n+5),.ui-sortable tr:nth-child(6n+6){background:#fff !important}
.ui-sortable tr:nth-child(n+7){background:#ebe9e9 !important;opacity:0.5}
tr.current{height:115px}
.cell:nth-child(1) select,.count .cell:nth-child(2),.count .cell:nth-child(3){display:none}
.tab-lista tr td.cell:nth-child(2){width:220px}
.tab-lista tr td.cell:nth-child(4){width:70px}
.tab-lista tr td.cell:nth-child(5){width:320px}
.tab-lista tr td.cell:last-child{width:110px}
</style>
<div id="table-0" class="tabela2 col-lg-12 col-md-12">
	<div class="panel panel-white">
		<div class="panel-heading">
			<form id="id-form-filtro" onsubmit="return adm.busca();">
				<div class="lrow tab">
					<!--<div class="cell"><select name="tp" class="form-control"></select></div>-->
					<!--<div class="cell itxt">
						<input type="text" name="q" class="filtro-q form-control"/>
					</div>
					<div class="checker" style="margin-top:8px"><span><input type="checkbox" name="rel" value="1" title="Pesquisa com Relevâcia"></span></div>-->
					<!--<div class="cell right"><a class="filtro-bt"></a></div>-->
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
					<div class="cell right"><span class="save-pos"></span><!--<a class="tab-add"></a>--></div>
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
					<div class="cell right"><span class="save-pos"></span><!--<a class="tab-add"></a>--></div>
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

	$('.tab-lista').sortable({
		scroll:true,
		scrollSpeed:30,
		containment:'parent',
		forceHelperSize:true,
		placeholder:'current',
		cursor: 'move',
		helper: function(event, element) {
			return element.clone().appendTo('body');
		},
	});
	$('.tab-lista').disableSelection();
});

var adm = $.tab({
	c:{a:'ordenar-home',mt:'este Produto',ma:'Novo Produto',add:'admin/ordena-home/',fn:function(){
		return $(ft.f).serializeObject();
	}},
	e:'#table-0',
	v:'Nenhum Produto',
	l:'Buscando...',
	img:1,
	ajax:1,
	debugBusca:0,
	debugBuscaText:0,
	debugBuscaXML:0,
	o:'oh asc',
	oi:['id','oh','s','dc','t','n','o','ct'],
	th:[
		{t:2,n:'Imagem',w:104,o:'',tt:'n',a:'upload/categorias/thumb/',c:'i',d:'default.jpg',l:2,dl:1},
		{n:'Título',w:250,o:'',tt:'n',l:1},
		{t:1,n:'Ordem',w:80,o:'',bt:'ord'}
	]
});
</script>
<script type="text/javascript">$.extend(ft,"<?=json_encode($a)?>");</script>
<?
Inline::b();
?>