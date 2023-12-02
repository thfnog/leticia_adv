<div id="table-0" class="tabela2 col-lg-12 col-md-12">
	<div class="panel panel-white">
		<div class="panel-heading">
			<form id="id-form-filtro" onsubmit="return adm.busca();">
				<div class="lrow tab">
					<div class="cell">
						<select name="qt" title="Exibir" class="form-control"></select>
					</div>
					<div class="cell itxt">
						<input type="text" name="q" class="filtro-q form-control" placeholder="Nome, Telefone ou E-mail!"/>
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
});

var adm = $.tab({
	c:{a:'contatos',mt:'este Contato',ma:'Novo Contato',add:'admin/contato/',fn:function(){
		return $(ft.f).serializeObject();
	}},
	e:'#table-0',
	v:'Nenhum Contato',
	l:'Buscando...',
	ajax:1,
	debugBusca:0,
	o:'dc desc',
	oi:['id','dc','da','nome','email','telefone'],
	th:[
		{n:'ID',w:80,o:'id',a:'admin/contato/',c:'id',tb:0},
		{n:'Nome',w:150,o:'nome',l:1},
		{n:'E-mail',w:150,o:'email',l:1},
		{n:'Telefone',w:150,o:'telefone',l:1},
		{t:1,n:'VER',w:80,o:'id',c:'id',tb:0,bt:[{tt:1,m:'cp',a:'admin/contato/',i:['isearch'],t:['Ver Contato']}]},
	]
});
ft.qt = [10,15,20,30,50,60,100];
</script>
<?php
Inline::b();
?>