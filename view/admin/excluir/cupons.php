<div id="table-0" class="tabela2 col-lg-12 col-md-12">
	<div class="panel panel-white">
		<div class="panel-heading">
			<form id="id-form-filtro" onsubmit="return adm.busca();">
				<div class="lrow tab">
					<div class="cell">
						<select name="qt" title="Exibir" class="form-control"></select>
					</div>
					<div class="cell w240"<?=$s->tipoAdm==5?' style="display:none"':''?>>
						<select name="tipo" class="form-control"></select>
					</div>
					<div class="cell itxt w110">
						<input type="text" name="dci" placeholder="Cupom de" title="Cupom de" class="form-control mk-data"/>
					</div>
					<div class="cell itxt w110">
						<input type="text" name="dcf" placeholder="Cupom até" title="Cupom até" class="form-control mk-data"/>
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

	e = f.tipo;
	o = e.options;
	$.each(_.tipo,function(i,v){
		o[i=o.length] = new Option(v[0],v[1]);
		if(v[1]==_.tipo)e.selectedIndex = i;
	});

	$('.mk-data').mask('99/99/9999');
});

var adm = $.tab({
	c:{a:'cupom',mt:'este Cupom',ma:'Novo Cupom',add:'admin/cupom/',fn:function(){
		return $(ft.f).serializeObject();
	}},
	e:'#table-0',
	v:'Nenhum Cupom',
	l:'Buscando...',
	img:0,
	ajax:1,
	debugBusca:0,
	debugBuscaText:0,
	debugBuscaXML:0,
	o:'dc desc',
	oi:['id','dc','da','s','t','d','i','it','q'],
	th:[
<?
if($s->tipoAdm==5){
?>
		{n:'Código do Cupom',w:90,o:'c,t',l:1,tt:'c',a:'admin/cupom-utilizado/',c:'id',tb:0},
		{n:'Utilizado',w:90,o:'u',l:1,tt:'u',a:'admin/cupom-utilizado/',c:'id',tb:0},
		{n:'Data de Início',w:130,o:'di',tt:'_di'},
		{n:'Data de Validade',w:130,o:'dv',tt:'_dv'},
		{t:1,n:'VER',w:80,o:'id',c:'id',tb:0,bt:[{tt:1,m:'cp',a:'admin/cupom-utilizado/',i:['isearch'],t:['Visualizar']}]},
<?
}else{
?>
		{n:'ID',w:50,o:'id',a:'admin/cupom/',c:'id',tb:0},
		{n:'Nome do Cupom',w:650,o:'t',l:1,tt:'n',a:'admin/cupom/',c:'id',tb:0},
		{n:'Código do Cupom',w:90,o:'c,t',l:1,tt:'c',a:'admin/cupom/',c:'id',tb:0},
		{n:'Utilizado',w:90,o:'u',l:1,tt:'u',a:'admin/cupom-utilizado/',c:'id',tb:0},
		{n:'Tipo de Cupom',w:250,o:'tipo_cupom',tt:'_tipo_cupom',l:1},
		{n:'Data de Início',w:130,o:'di',tt:'_di'},
		{n:'Data de Validade',w:130,o:'dv',tt:'_dv'},
		//{n:'Cadastrado em',w:130,o:'dc',tt:'_dc'},
		{t:1,n:'Opções',w:90,o:'s,u',bt:'opt'}
<?
}
?>
	]
});
ft.view = 10;
ft.qt = [10,15,20,30,50,60,100];
ft.tipo = [['Selecione o Tipo de Cupom',0],['Produtos','produto'],['Todos Produtos','produtos'],['Categoria','categoria']];
</script>
<script type="text/javascript">
$.extend(ft,<?=json_encode($a)?>);
</script>
<?
Inline::b();
?>