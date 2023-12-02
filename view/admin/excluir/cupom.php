<div class="col-md-12">
	<div class="panel panel-white">
		<div class="panel-heading clearfix">
			<h4 class="panel-title"><?=$s->id?'Alterar':'Novo'?> Cupom</h4>
		</div>
		<div class="panel-body">
			<form id="id-form">
				<div class="form-group col-md-12">
					<label for="n">* Nome</label>
					<input type="text" class="form-control" id="n" name="n" placeholder="Digite o nome do cupom" value="<?=strh($rs->n)?>">
				</div>
				<div class="form-group col-md-12">
					<label for="c">* Código</label>
					<input type="text" class="form-control" id="c" name="c" placeholder="Digite o código do cupom" value="<?=strh($rs->c)?>">
				</div>
				<div class="form-group col-md-12">
					<label for="tipo_cupom">* Tipo de Cupom:</label>
					<select class="form-control" id="tipo_cupom" name="tipo_cupom"></select>
				</div>
				<div id="categorias">
					<div class="form-group col-md-12">
						<h4 class="no-m m-b-sm m-t-lg">Categoria</h4>

						<select class="js-categorias form-control" multiple="multiple" style="width:100%" name="idc[]">
<?
	if($s->id&&$rs->tipo_cupom=='categoria'){
		$sc = $b->query("select c.id,c.h1 n from cat c left join cupom_ax a on c.id=a.ida where a.idc='{$s->id}' and s order by t");
		while($rc=$sc->fetchObject()){
?>
							<option value="<?=$rc->id?>" selected="selected"><?=$rc->n?></option>
<?
		}
	}
?>
						</select>
					</div>
				</div>
				<div id="produtos">
					<div class="form-group col-md-12">
						<h4 class="no-m m-b-sm m-t-lg">Produtos</h4>
						<select class="js-produtos form-control" multiple="multiple" tabindex="-1" style="width:100%" name="idp[]">
<?
	if($s->id&&$rs->tipo_cupom=='produto'){
		$sp = $b->query("select p.id,p.h1 n from produto p left join cupom_ax a on p.id=a.idp where a.idc='{$s->id}' order by p.h1");
		while($rp=$sp->fetchObject()){
			$idp = $rp->id;
			$rf = $b->query("select i from fotos where tipo='produto' and idp='$idp'")->fetchObject();
			$rf->i = $rf->i?$rf->i:'thumb/default.jpg';

?>
							<option value="<?=$rp->id?>" selected="selected" data-image="<?=$rf->i?>"><?=$rp->n?></option>
<?
		}
	}
?>
						</select>
					</div>
				</div>
				<div class="form-group col-md-12">
					<label for="q">* Quantidade</label>
					<input type="number" class="form-control" id="q" name="q" min="1" placeholder="Digite a quantidade de cupom" value="<?=$rs->q?strh($rs->q):1?>">
				</div>
				<div class="form-group col-md-12">
					<label for="l">* Limite por Cliente</label>
					<input type="number" class="form-control" id="l" name="l" min="1" placeholder="Digite o limite de vezes que o cupom pode ser usado por cliente" value="<?=$rs->l?strh($rs->l):1?>">
				</div>
				<div class="form-group col-md-12">
					<label for="tipo_desconto">* Tipo de Desconto:</label>
					<select class="form-control" id="tipo_desconto" name="tipo_desconto"></select>
				</div>
				<div id="porcentagem">
					<div class="form-group col-md-12">
						<label for="dp">* Valor</label>
						<input type="number" class="form-control" id="dp" name="dp" min="1" placeholder="Digite o valor de desconto" value="<?=$rs->dp?$rs->dp:1?>">
					</div>
				</div>
				<div id="fixo">
					<div class="form-group col-md-12">
						<label for="df">* Valor</label>
						<input type="number" class="form-control" id="df" name="df" min="0.1" step="0.1" placeholder="Digite o valor de desconto" value="<?=$rs->df?$rs->df:0.1?>">
					</div>
				</div>
				<div class="form-group col-md-12">
					<label for="di">* Data de Início:</label>
					<input type="text" id="di" name="di" placeholder="Data de início" maxlength="10" value="<?=$rs->di?datef($rs->di,8):''?>" class="mk-data date-picker form-control"/></label>
				</div>
				<div class="form-group col-md-12">
					<label for="dv">* Data de Validade:</label>
					<input type="text" id="dv" name="dv" placeholder="Data de validade" maxlength="10" value="<?=$rs->dv?datef($rs->dv,8):''?>" class="mk-data date-picker form-control"/></label>
				</div>
				<div class="form-group col-md-12">
					<label for="v">* Valor Mínimo</label>
					<input type="number" class="form-control" id="v" name="v" min="0.1" step="0.1" placeholder="Digite o valor mínimo do pedido para poder usar o cupom" value="<?=$rs->v?$rs->v:0.1?>">
				</div>
				<div class="form-group col-md-12">
					<label for="s">
						<span style="display:block;float:left;margin-right:5px">Ativo</span>
						<span><input type="checkbox" id="s" name="s" value="1" class="ckb"<?=$rs->s||!$s->id?' checked':''?>></span>
					</label>
				</div>
				<div class="clearfix" style="height:40px"></div>
				<div class="form-group col-md-12">
					<input type="submit" class="btn btn-success"/>
				</div>
			</form>
		</div>
	</div>
</div>
<?
Inline::a();
?>
<link rel="stylesheet" type="text/css" href="assets/css/plugins/bootstrap-datepicker/css/datepicker3.css"/>
<link rel="stylesheet" type="text/css" href="assets/css/plugins/select2/css/select2.min.css"/>
<script type="text/javascript" src="assets/js/admin/jquery.validate.min.js"></script>
<script type="text/javascript" src="assets/js/admin/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="assets/js/admin/select2.min.js"></script>
<script type="text/javascript">
var adm = $.form({
	a:'cupom',
	cgT:function(h){
		var _ = this,f = _.f,tipo_cupom = $(this.f.tipo_cupom).val();
		$('#produtos')[tipo_cupom=='produto'?'show':'hide'](h?null:300);
		$('#categorias')[tipo_cupom=='categoria'?'show':'hide'](h?null:300);
		$('.js-produtos').attr('disabled',tipo_cupom!='produto');
		$('.js-categorias').attr('disabled',tipo_cupom!='categoria');
	},
	cgD:function(h){
		var _ = this,f = _.f,tipo_desconto = $(this.f.tipo_desconto).val();
		$('#porcentagem')[tipo_desconto=='porcentagem'?'show':'hide'](h?null:300);
		$('#fixo')[tipo_desconto=='fixo'?'show':'hide'](h?null:300);
		$('#dp').attr('disabled',tipo_desconto!='porcentagem');
		$('#df').attr('disabled',tipo_desconto!='fixo');
	},
	id:"<?=$s->id?>",
	back:'<?=$s->back?>',
	load:function(_,F,f,e,o,i){
		e = f.tipo_cupom;
		o = e.options;
		$.each(_.tipo,function(i,v){
			o[i=o.length] = new Option(v[0],v[1]);
			if(v[1]==_.tipo_cupom)e.selectedIndex = i;
		});
		$(e).change(function(){
			_.cgT();
		});
		_.cgT(1);

		e = f.tipo_desconto;
		o = e.options;
		$.each(_.desconto,function(i,v){
			o[i=o.length] = new Option(v[0],v[1]);
			if(v[1]==_.tipo_desconto)e.selectedIndex = i;
		});
		$(e).change(function(){
			_.cgD();
		});
		_.cgD(1);

		$('.mk-data').mask('99/99/9999');
	},
	//tipo:[['Selecione o Tipo de Cupom',0],['Ambientes',1],['Sub ambientes',2],['Temas',3],['Fabricantes',4],['Produtos',5],['Todos Produtos',6]],
	tipo:[['Selecione o Tipo de Cupom',0],['Produtos','produto'],['Todos Produtos','produtos'],['Categoria','categoria']],
	desconto:[['Selecione o Tipo de Desconto',0],['Porcentagem','porcentagem'],['Fixo','fixo']],
});
</script>
<script type="text/javascript">
$.extend(adm,<?=json_encode($a)?>);
</script>
<script type="text/javascript">
$(document).ready(function() {
	$.validator.addMethod('valueNotEquals', function(value, element, arg){
		return arg != value;
	}, 'Campo obrigatório.');
    var validator = $('#id-form').validate({
        rules: {
			n: {required: true},
			c: {required: true},
			tipo_cupom: {
				valueNotEquals: 0,
				required: true
			},
			q: {required: true},
			l: {required: true},
			tipo_desconto: {
				valueNotEquals: 0,
				required: true
			},
			di: {required: true},
			dv: {required: true},
       }
    });
	$('.date-picker').datepicker({
		format: 'dd/mm/yyyy',
    });
});
$(document).ready(function() {
	$.fn.select2.amd.require(['select2/selection/search'], function (Search) {
		var oldRemoveChoice = Search.prototype.searchRemoveChoice;
		
		Search.prototype.searchRemoveChoice = function () {
			oldRemoveChoice.apply(this, arguments);
			this.$search.val('');
		};
		$('.js-categorias').select2({
			placeholder: 'Buscar Categorias',
			ajax: {
				url:'ajax/g/categorias.json',
				dataType:'json',
				delay:250,
				data:function(params){
					return{
						q:params.term
					};
				},
				processResults:function(data){
					return {
						results: data
					};
				},
				cache: true
			},
			minimumInputLength: 2,
		});
		$('.js-produtos').select2({
			placeholder: 'Buscar Produtos',
			ajax: {
				url:'ajax/g/produtos.json',
				dataType:'json',
				delay:250,
				data:function(params){
					return{
						q:params.term,
<?
if($s->id){
?>
						id:<?=$s->id?>
<?
}
?>
					};
				},
				processResults:function(data){
					return {
						results: data
					};
				},
				cache: true
			},
			minimumInputLength: 2,
			templateResult:formatState,
			templateSelection:formatState,
		});
		function formatState (data) {
			if (!data.id)return data.text;
			var image = $(data.element).data('image');
			var datad = $(
				'<span><img width=\"100\" src=\"'+(data.image?data.image:'upload/produtos/'+image+'')+'\" class=\"img-flag\" style=\"margin-right:15px\">'+data.text+'</span>'
			);
			return datad;
		};
	});
});
</script>
<?
Inline::b();
?>