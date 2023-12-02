(function($){
window.mail = $.form({
	u:'',
	a:'email',
	F:'#newsletter-form',
	style:false,
	sub:'INSCREVER'
});
})(jQuery);
(function($){
window.con = $.form({
	a:'contato',
	sub:'ENVIAR',
	style:false,
	F:'#contactForm',
	load:function(_,F,f,e,o,i){  
		$('.mk-data').mask('99/99/9999');
		$('.mk-tel').mask('(99) 9999-9999');
		$('.mk-cel').focusout(function(){
			var e = $(this);
			e.unmask().mask(e.val().replace(/\D/g,'').length>10?'(99) 99999-999?9':'(99) 9999-9999?9');
		}).focusout();
	}
});
})(jQuery);
(function($){
window.alt = $.form({
//$.fn.alt = $.form({
	a:'alterar-cliente',
	F:'#form-alterar-cadastro',
	style:false,
	sub:'Alterar',
	cgCep:function(){
		var _ = this,f = _.f,c = $(f.cep),cep = c.val(),re = /^\D*(\d{2})\D*(\d{3})\D*(\d{3})\D*$/;
		if(re.test(cep))cep = cep.replace(re,'$1$2-$3'),c.val(cep);
		else return false;
		if(_.cep==cep)return false;
		_.cep = cep;
		$.getScript('http://republicavirtual.com.br/web_cep.php?formato=javascript&cep='+cep,function(){
			var r = window.resultadoCEP;
			if(r.resultado){
				$(f.rua).val(unescape(r.tipo_logradouro+' '+r.logradouro));
				$(f.bairro).val(unescape(r.bairro));
				$(f.city).val(unescape(r.cidade));
				$(f.uf).val(unescape(r.uf).toUpperCase());
			}else _.cep = 0;
			delete r;
			window.resultadoCEP = undefined;
		});
	},
	cgT:function(h){
		var _ = this,f = _.f,tp = $(this.f.tp).val();
		$('.cliente')[tp=='F'?'show':'hide'](h?null:300);
		$([f.cpf,f.rg,f.dn]).attr('disabled',tp!='F');
		$('.empresa')[tp=='J'?'show':'hide'](h?null:300);
		$([f.r,f.cnpj,f.ie]).attr('disabled',tp!='J');
	},
	reset:function(_){
		//_.cgT(1);
	},
	load:function(_,F,f,e,o){
		$(f.cep).bind('change keyup',function(){
			_.cgCep();
		});

		e = f.tp;
		o = e.options;
		$.each(_.tipo,function(i,v){
			o[i=o.length] = new Option(v[0],v[1]);
			if(v[1]==_.tp)e.selectedIndex = i;
		});
		$(e).change(function(){
			_.cgT();
		});
		_.cgT(1);

		e = f.uf;
		o = e.options;
		$.each(_.ufs,function(i,v){
			o[i=o.length] = new Option(v,v);
			if(v==_.uf)e.selectedIndex = i;
		});

		e = f.simples_nacional;
		o = e.options;
		$.each(_.opcao,function(i,v){
			o[i=o.length] = new Option(v[0],v[1]);
			if(v[1]==_.simples_nacional)e.selectedIndex = i;
		});

		e = f.ide_mei;
		o = e.options;
		$.each(_.opcao,function(i,v){
			o[i=o.length] = new Option(v[0],v[1]);
			if(v[1]==_.ide_mei)e.selectedIndex = i;
		});

		$('.mk-data').mask('99/99/9999');
		$('.mk-cpf').mask('999.999.999-99');
		$('.mk-cnpj').mask('99.999.999/9999-99');
		$('.mk-cep').mask('99999-999');
		$('.mk-cel').focusout(function(){
			var e = $(this);
			e.unmask().mask(e.val().replace(/\D/g,'').length>10?'(99) 99999-999?9':'(99) 9999-9999?9');
		}).focusout();
	},
	tipo:[['Selecione o Tipo de Cadastro',0],['Pessoa Física','F'],['Pessoa Jurídica','J']],
	ufs:['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PR','PB','PA','PE','PI','RJ','RN','RS','RO','RR','SC','SE','SP','TO'],
	opcao:[['Não','N'],['Sim','S']]
});
})(jQuery);
(function($){
window.ind = $.form({
	a:'indique',
	sub:'ENVIAR',
	style:false,
	F:'#indiqueForm',
	load:function(_,F,f,e,o,i){}
});
window.avi = $.form({
	a:'avise',
	sub:'ENVIAR',
	style:false,
	F:'#aviseForm',
	load:function(_,F,f,e,o,i){}
});
})(jQuery);
(function($){
window.car = $.form({
	a:'pedido-cli',
	sub:'FECHAR PEDIDO',
	style:false,
	F:'#pedido-cli',
	load:function(_,F,f,e,o,i){}
});
})(jQuery);
(function($){
window.ped = $.form({
	a:'fechar-pedido',
	sub:'FECHAR PEDIDO',
	style:false,
	F:'#fechar-pedido',
	load:function(_,F,f,e,o,i){}
});
})(jQuery);
(function($){
window.indb = $.form({
	a:'indique-blog',
	sub:'ENVIAR',
	style:false,
	F:'#indiqueForm',
	load:function(_,F,f,e,o,i){}
});
})(jQuery);
