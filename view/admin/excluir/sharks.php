<div id="table-0" class="tabela2 col-lg-12 col-md-12">
	<div class="panel panel-white">
		<div class="panel-heading">
			<form id="id-form-filtro" onsubmit="return adm.busca();">
				<div class="lrow tab">
					<div class="cell">
						<select name="qt" title="Exibir" class="form-control"></select>
					</div>
					<div class="cell">
						<select name="sexo" title="Sexo" class="form-control"></select>
					</div>
					<div class="cell">
						<select name="segmento" title="Segmento" class="form-control"></select>
					</div>
					<div class="cell">
						<select name="uf" id="uf" title="Estado" class="form-control">
							<option>-- Estado --</option>
<?
$su = $b->query("select * from estado where pais=1 order by uf");
while($ru=$su->fetchObject()){
?>
							<option value="<?=$ru->id?>"><?=$ru->nome?></option>
<?
}
?>
						</select>
					</div>
					<div class="cell">
						<select name="city" id="city" title="Cidade" class="form-control"><option>-- Cidade --</option></select>
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

	e = f.sexo;
	o = e.options;
	$.each(_.sx,function(i,v){
		o[i=o.length] = new Option(v[0],v[1]);
		if(v[1]==_.sexo)e.selectedIndex = i;
	});

	e = f.segmento;
	o = e.options;
	$.each(_.seg,function(i,v){
		o[i=o.length] = new Option(v[0],v[1]);
		if(v[1]==_.seg)e.selectedIndex = i;
	});
});

var adm = $.tab({
	c:{a:'sharks',mt:'este Cadastro',ma:'Novo Contato',add:'admin/shark/',fn:function(){
		return $(ft.f).serializeObject();
	}},
	e:'#table-0',
	v:'Nenhum Cadastro',
	l:'Buscando...',
	ajax:1,
	debugBusca:0,
	o:'dc desc',
	oi:['id','dc','da','nome','email','telefone','city'],
	th:[
		//{n:'ID',w:80,o:'id',a:'admin/shark/',c:'id',tb:0},
		{n:'Nome',w:150,o:'nome',l:1},
		{n:'E-mail',w:150,o:'email',l:1},
		{n:'Telefone',w:150,o:'telefone',l:1},
		{n:'Cidade',w:130,o:'city',tt:'_city'},
		{n:'Cadastrado em',w:130,o:'dc',tt:'_dc'},
		{t:1,n:'VER',w:80,o:'id',c:'id',tb:0,bt:[{tt:1,m:'cp',a:'admin/shark/',i:['isearch'],t:['Ver Contato']}]},
	]
});
ft.qt = [10,15,20,30,50,60,100];
ft.sx = [['-- Sexo --',0],['Feminino',1],['Masculino',2]];
ft.seg = [['-- Segmento --',0],['Atleta IFBB',1],['Crossfit',2],['Modelo',3],['Life Style',4],['Artes Marciais',5],['Futebol',6],['Ciclismo',7],['Outros',8]];

$('#uf').on('change',function(){
	var uf = $(this).val();
	$("#city").empty();
	$.get('ajax/get-cidades.json',{uf:uf},function(x){
		if(x.ok){
			$("#city").append('<option>-- Selecione a Cidade --</option>');
			$.each(x.cidades,function(i,v){
				$("#city").append('<option value="'+i+'">'+v+'</option>');
			});
		}
		else{
			$("#city").append('<option>-- Selecione a Cidade --</option>');
			message(0,'Selecione o Estado!');
		}
	});
});
</script>
<?php
Inline::b();
?>