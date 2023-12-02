<link rel="stylesheet" href="css/confirm/jquery-confirm.min.css">
<link rel="stylesheet" href="css/confirm/no-bootstrap.css"><!-- USAR APENAS SE O LAYOUT NÃO TEM BOOTSTRAP -->
<script type="text/javascript" src="js/confirm/jquery-confirm.min.js"></script>
<script type="text/javascript">
function myFunction(event){
	if(jQuery('#pl1').is(':checked')&&jQuery('#pl2').is(':checked')){
		event.preventDefault();
		var data = jQuery('#contactForm').serialize();
		jQuery.post('a/u/comprar.json',data,function($){
		}).success(function(x){
			if(x.m){
				jQuery.alert({
					title: x.m,
					content: '',
					closeIcon: true,
					type: x.ok==1?'green':'red',
					autoClose: 'Fechar|2000',
				    typeAnimated: true,
					buttons: {
						Fechar: {
							text: 'FECHAR',
							btnClass: 'btn-red',
							action: function () {
							},
							keys: ['enter','esc'],
						}
					},
				});
			}
			if(x.ok==0&&x.l)location.href = x.l;
		});
	}
	else{
		event.preventDefault();
		implantacao = 'Você não contratou a consultoria na implantação. Este investimento lhe proporcionará maior aderência do CIGS ao seu negócio, aumentando seu retorno em termos de informarções personalizadas. Recomendamos a contratação.';
		treinamento = 'Você não contratou o treinamento para o uso do CIGS. Este investimento lhe proporcionará maior rapidez na implantação e maior probabilidades na exatidão dos dados e informações, lhe retornando maior segurança nas suas decisões. Recomendamos a contratação.';
		msg = (!jQuery('#pl1').is(':checked')?implantacao:'')+(!jQuery('#pl2').is(':checked')?(!jQuery('#pl1').is(':checked')?'<br><br>':'')+treinamento:'')+'<br><br>Caso queira realizar a contratação clique em cancelar!';
		jQuery.confirm({
			title: '',
			content: msg,
			columnClass: 'col-md-12',
			buttons: {
				somethingElse: {
					text: 'Continuar',
					btnClass: 'btn-blue',
					keys: ['enter'],
					action: function(){
						var data = jQuery('#contactForm').serialize();
						jQuery.post('a/u/comprar.json',data,function($){
						}).success(function(x){
							if(x.m){
								jQuery.alert({
									title: x.m,
									content: '',
									closeIcon: true,
									type: x.ok==1?'green':'red',
									autoClose: 'Fechar|2000',
									typeAnimated: true,
									buttons: {
										Fechar: {
											text: 'FECHAR',
											btnClass: 'btn-red',
											action: function () {
											},
											keys: ['enter','esc'],
										}
									},
								});
							}
							if(x.ok==0&&x.l)location.href = x.l;
						});
					}
				},
				cacelar: {
					text: 'Cancelar',
					btnClass: 'btn-red',
					keys: ['esc'],
					action: function(){
					}
				},
			}
		});
	}
}
(function($){
window.adm = {
	cgCep:function(){
		var _ = this,F = $('#contactForm'),f = F[0],c = $(f.cep),cep = c.val(),re = /^\D*(\d{2})\D*(\d{3})\D*(\d{3})\D*$/;
		if(re.test(cep))cep = cep.replace(re,'$1$2-$3'),c.val(cep);
		else return false;
		if(_.cep==cep)return false;
		_.cep = cep;
		$.getScript('http://republicavirtual.com.br/web_cep.php?formato=javascript&cep='+cep,function(){
			var r = window.resultadoCEP;
			if(r.resultado){
				$(f.rua).val(unescape(r.tipo_logradouro+' '+r.logradouro));
				$(f.bairro).val(unescape(r.bairro));
				if(r.uf){
					$(f.uf).val(unescape(r.uf).toUpperCase());
					_.cgC(unescape(r.uf).toUpperCase());
				}
				$(f.city).val(unescape(r.cidade).toUpperCase());
				$(f.num).focus();
			}else _.cep = 0;
			delete r;
			window.resultadoCEP = undefined;
		});
	},
	cgC:function(s){
		var _ = this,F = $('#contactForm'),f = F[0],e = f.city,o = e.options,id = $(f.uf).val();
		o.length = 0;
		$.each(_.cidades,function(i,v){
			if(i&&v[2]!=id)return;
			o[i=o.length] = new Option(v[0],v[1]);
			if(s==v[1])e.selectedIndex = i;
		});
	},
	cgTipo:function(s){
		var _ = this,F = $('#contactForm'),f = F[0],tipo = $(f.tipo).val();
		if(tipo=='L'||tipo=='E'){
			$('.representantes').hide();
			$('.socios').show();
			if(tipo=='L')$('.socios2').show();
			else $('.socios2').hide();
		}else if(tipo&&tipo!='L'){
			$('.socios, .socios2').hide();
			$('.representantes').show();
		}
	},
	load:function(_,F,f,e,o,i){ 
		var _ = this,F = $('#contactForm'),f = F[0];
		$(f.cep).bind('change keyup',function(){
			console.log('xita');
			_.cgCep();
		});

		$('.mk-cep').mask('99.999-999');
		$('.mk-data').mask('99/99/9999');
		$('.mk-cpf').mask('999.999.999-99');
		$('.mk-cnpj').mask('99.999.999/9999-99');
		$('.mk-tel').mask('(99) 9999-9999');
		$('.mk-cel').focusout(function(){
			var e = $(this);
			e.unmask().mask(e.val().replace(/\D/g,'').length>10?'(99) 99999-999?9':'(99) 9999-9999?9');
		}).focusout();

		e = f.uf;
		o = e.options;
		$.each(_.ufs,function(i,v){
			o[i=o.length] = new Option(v[0],v[1]);
			if(v[1]==_.uf)e.selectedIndex = i;
		});
		$(e).change(function(){
			_.cgC();
		});
		_.cgC(_.city);

		e = f.tipo;
		o = e.options;
		$(e).change(function(){
			_.cgTipo();
		});
		_.cgTipo(0);
	}
};
$.extend(true,adm,<?=json_encode($a)?>);
return adm.load();
})(jQuery);
</script>