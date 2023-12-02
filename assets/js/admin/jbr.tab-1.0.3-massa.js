//c = conf{
//		_:ref parent,a:'pg ajax',add:'new objeto e aterar como default',mt:'este objeto',ma:'title .tab-add',mp:'title .save-pos',
//		fbt:'element $ busca load',fn:func dados() para ajax
//	}
//e = element $ table
//load = [0 ou default=carrega no ready, 1=carrega na hora, 2=não carrega]
//v = msg void
//v = msg loading
//img = 0 ou 1; se as rows é do tipo img
//ajax = 0 ou 1; se carrega RS por ajax
//o = order by
//oi = [] indexes permitido no order by
/*
th = [{
	t:tipo; default:0; 0:text, 1:botoes, 2:img
	n:titulo
	w:width
	oa:text order ASC
	od:text order DESC
	o:orders
	oi:order index; default: O[0]
	tt:field valor; default: O[0]
	dtt:field valor se não RS.TT
	tta:texto alternativo se não RS.TT e não RS.DTT

	T==0 text
		l:[0 ou 1]; default:0; .cell.line
		tit:default:1 se L
		a:url antes
		b:url depois
		c:filed
		d:url se não C
		tb:[0 ou 1]; default:1; attr(target,_blank)

	T==1 botoes
		tit:default:0
		bt:botao[
			{}:{t:1=stt, f:'function do click'},
			s:status={t:1,f:'block'},
			a:alterar,
			d:delete,
			ot:order-top,
			ou:order-up,
			od:order-down,
			ob:order-bottom,
				{}:{
					tt:tipos pre definidos:0=stt,1=alt,2=del||bt,
						f=func click:(e element bt,c {}configs,r {}resultset,t {}th,b {}bt):this=$.tab,
						ld='[]load em conf',
						u='url ajax'default: M
					l:islink,
					tb:is_blank,
					m:'RS[m]; multiple valor: i,t,a,id,b',
					i:'icone',
					t:'title',
					a:'str antes de id, default:_.c.add',
					b:'str depois de id'
					id:'undefined?rs.id:null?'':id',
				},
				//s:status={t:0,c:'s',f:'block'},
				//a:alterar={t:1,la:'',lb:'',t:'Alterar'},
				tt=0:status,
				d||tt=1:delete,
				tt==2:alterar,
				ot:order-top,
				ou:order-up,
				od:order-down,
				ob:order-bottom,
		]

	T==2 img
		tit:default:1
		l:default:1; 1:.cell.iline, 2:.cell .box-img-center
		a:url antes
		b:url depois
		c:filed
		d:url padrão se não C
		iw:width
		ih:height
		im:margin
		imt:margin-top
		iml:margin-left
		il:[0 ou 1]; default:1; .load
		auto:[0 ou 1]; default:1; .auto
		bg:class bg; default:1; 1:.w, 2:.b
		dil:=IL se não C; default:IL;
		dauto:=AUTO se não C; default:AUTO
		dbg:=BG se não C; default:BG;

	tit:[0 ou 1] e TT; attr(title,TT)
*/
//}]
//rs = [] result set

(function($){
	var _th = {t:0,n:'',w:0,oa:'',od:'',o:'',oi:null,tt:null,dtt:'',tta:''},
	_th0 = {l:false,tit:null,a:'',b:'',c:'',d:'',tb:1},
	_th1 = {tit:false,bt:[]},
	_th2 = {tit:true,l:1,a:'',b:'',c:'',d:'',iw:null,ih:null,im:null,imt:null,iml:null,il:true,auto:true,bg:1,dil:null,dauto:null,dbg:null},

	stt = function(_,e,id,b){
		var s,v,
		l = _[b.ld],
		m = b.m,
		u = b.u||b.m,
		a = b.a||_.a,
		i = b.i,
		t = b.t;
		if(l[id])return;
		e = $(e);
		s = e.hasClass(i[1])?1:0;
		e.attr('class','ico load');
		l[id] = 1;
		$.post('ajax/'+u+'/'+a+'.json',{id:id,s:s?0:1},function(x){
			//if(x.m)alert(x.m);
			if(x.m){
				$('#sys-notification').show();
				var answer = x.ok==1?'success':'danger';
				var icon = x.ok==1?'check':'question';
				$('#notification').html('<div class="alert alert-'+answer+'"><i class="fa fa-'+icon+'-circle"></i> '+x.m+'<button type="button" class="close" data-dismiss="alert">×</button></div>');
				$("html, body").animate({scrollTop:100},600);
			}
		},'json').complete(function(){
			e.attr({'class':'ico '+i[s],title:t[s]});
			l[id] = 0;
		});
	},
	del = function(_,e,id){
		var l = _.ld,ok;
		if(l[id]||!confirm('Você deseja excluir '+_.mt+'?'))return;
		e = $(e).addClass('load');
		l[id] = 1;
		$.post('ajax/d/'+_.a+'.json',{id:id},function(x){
			//if(x.m)alert(x.m);
			if(x.m){
				$('#sys-notification').show();
				var answer = x.ok==1?'success':'danger';
				var icon = x.ok==1?'check':'question';
				$('#notification').html('<div class="alert alert-'+answer+'"><i class="fa fa-'+icon+'-circle"></i> '+x.m+'<button type="button" class="close" data-dismiss="alert">×</button></div>');
				$("html, body").animate({scrollTop:100},600);
			}
			ok = x.ok;
		},'json').complete(function(){
			if(ok){
				$.reIndex(_._.rs,1,function(v,i,j){
					return v.id===id;
				});
				e.parent().parent().remove();
				delete _._.el[id];
				delete _._.RS[id];
				zero(_._);
			}else e.removeClass('load');
			l[id] = 0;
		});
	},
	fin = function(_,e,id,b){
		var s,l = _.ld,
		m = b.m,
		u = b.u||b.m,
		a = b.a||_.a,
		i = b.i,
		t = b.t;
		e = $(e);
		s = e.hasClass(i[1])?1:0;
		if(l[id]||!confirm((s==0?'Você deseja finalizar ':'Você deseja reativar ')+_.mt+'?'))return;
		e.attr('class','ico load');
		l[id] = 1;
		$.post('ajax/f/'+_.a+'.json',{id:id,s:s?0:1},function(x){
			//if(x.m)alert(x.m);
			if(x.m){
				$('#sys-notification').show();
				var answer = x.ok==1?'success':'danger';
				var icon = x.ok==1?'check':'question';
				$('#notification').html('<div class="alert alert-'+answer+'"><i class="fa fa-'+icon+'-circle"></i> '+x.m+'<button type="button" class="close" data-dismiss="alert">×</button></div>');
				$("html, body").animate({scrollTop:100},600);
			}
			if(x.ok){
				s = s?0:1;
				if(v=_._.RS[id])v[m] = s;
				b.ok&&b.ok(v);
			}
		},'json').complete(function(){
			e.attr({'class':'ico '+i[s],title:t[s]});
			l[id] = 0;
		});
	},
	savePos = function(_,e,s,l,m,u){
		var d = {};
		e = e||_._.e.find(s||'.save-pos');
		l = l||'lo';
		m = m||'o';
		u = u||m;
		if(_[l])return;
		e.addClass('load');
		_[l] = 1;
		_._.e.find('.tab-lista .lrow').each(function(i){
			d['o'+$(this).attr('_id')] = i;
		});
		$.post('ajax/'+u+'/'+_.a+'.json',d,function(x){
			//if(x.m)alert(x.m);
			if(x.m){
				$('#sys-notification').show();
				var answer = x.ok==1?'success':'danger';
				var icon = x.ok==1?'check':'question';
				$('#notification').html('<div class="alert alert-'+answer+'"><i class="fa fa-'+icon+'-circle"></i> '+x.m+'<button type="button" class="close" data-dismiss="alert">×</button></div>');
				$("html, body").animate({scrollTop:100},600);
			}
			if(x.o)$.each(x.o,function(k,v){
				if(k=_._.RS[k])k[m] = v;
			});
		},'json').complete(function(){
			e.removeClass('load');
			_[l] = 0;
		});
	},
	pos = function(e,t){
		var r = $(e).parent().parent(),l = r.parent();
		if(t==1)l.prepend(r);
		if(t==2)r.prev().before(r);
		if(t==3)r.next().after(r);
		if(t==4)l.append(r);
	},

	init = function(_){
		var t;
		_.e = $(_.e);
		t = _.e.find('.lrow.th').html('');
		if(_.v)_.e.find('.void').html('<td class="cell">'+_.v+'</td>');
		if(_.l)_.e.find('.loading').css('display','none').html('<td class="cell">'+_.l+'</td>');
		_.e.find('.tab-add').addClass('ico iadd').attr({href:_.c.add||'',title:_.c.ma||''});
		_.e.find('.save-pos').addClass('ico isave').attr('title',_.c.mp||'Salvar Ordem').click(function(){
			savePos(_.c);
		});
		if(_.c.fbt==null)_.c.fbt = '.filtro-bt';
		_.e.find(_.c.fbt).addClass('ico isearch').attr('title','Pesquisar...').click(function(){
			busca(_);
		});
		$.each(_.th,function(i,v){
			if($.type(v)!='object'){
				delete _.th[i];
				return;
			}
			_.th[i] = v = $.extend(true,{},_th,v);
			if($.type(v.o)==='string')v.o = $.sort(v.o);
			if(v.oi==null&&v.o[0])v.oi = v.o[0][0];
			if(v.tt==null&&v.o[0])v.tt = v.o[0][0];

			if(v.t===0){
				_.th[i] = v = $.extend(true,{},_th0,v);
				if(v.l&&v.tit==null)v.tit = 1;
			}else if(v.t===1){
				_.th[i] = v = $.extend(true,{},_th1,v);
//	{}:{
//		tt:tipos pre definidos:0=stt,1=alt,2=del||bt, f=func click:(e element bt,c {}configs,r {}resultset,t {}th,b {}bt):this=$.tab, ld='[]load em conf', u='url ajax'default: M
//		l:islink,tb:is_blank,m:'v[m]; multiple valor: i,t,a,id,b',i:'icone',t:'title',a:'str antes de id, default:_.c.add',id:'undefined?rs.id:null?'':id',b:'str depois de id'
//	},
//	//s:status={t:0,c:'s',f:'block'},
//	//a:alterar={t:1,la:'',lb:'',t:'Alterar'},
//	tt=0:status,
//	d||tt=1:delete,
//	tt==2:alterar,
//	ot:order-top,
//	ou:order-up,
//	od:order-down,
//	ob:order-bottom,
				if(v.bt==='ord')v.bt = ['ot','ou','od','ob'];
				if(v.bt==='opt')v.bt = ['s',' ','a',' ','d'];
				if($.isArray(v.bt))$.each(v.bt,function(j,w){
					var _w;
					if($.type(w)!='object'){
						if(w==='s')w = {tt:0};
						if(w==='a')w = {tt:1};
						if(w==='d')w = {tt:2};
						if(w==='f')w = {tt:3};
						if(w==='i')w = {tt:4};
						if(w==='ot')w = {t:'Primeira Posição',i:'iarrow-top',f:function(e){pos(e,1);}};
						if(w==='ou')w = {t:'Subir uma Posição',i:'iarrow-up',f:function(e){pos(e,2);}};
						if(w==='od')w = {t:'Descer uma Posição',i:'iarrow-down',f:function(e){pos(e,3);}};
						if(w==='ob')w = {t:'Última Posição',i:'iarrow-bottom',f:function(e){pos(e,4);}};
						v.bt[j] = w;
					}else if($.isEmptyObject(w))delete v.bt[j];
					if($.type(w)==='object'){
						if(w.tt===0)_w = {m:'s',ld:null,u:null,a:null,i:['iblock','iunblock'],t:['Ativar','Desativar'],ok:null,f:function(e,c,r,t,b){stt(c,e,r.id,b);}};
						if(w.tt===1)_w = {l:1,t:'Alterar',i:'ialt'};
						if(w.tt===2)_w = {t:'Excluir',i:'idel',ok:null,f:function(e,c,r){del(c,e,r.id);}};
						if(w.tt===3)_w = {m:'s',ld:null,u:null,a:null,i:['iblock','iunblock'],t:['Finalizar','Reativar'],ok:null,f:function(e,c,r,t,b){fin(c,e,r.id,b);}};
						if(w.tt===4)_w = {l:1,t:'Responder',i:'imail'};
						if(_w)delete w.tt,v.bt[j] = w = $.extend(_w,w);
						if('ld' in w&&w.ld==null)w.ld = 'l'+w.m;
						if(w.ld&&!_.c[w.ld]&&$.type(_.c[w.ld])!='object')_.c[w.ld] = {};
						w.ok = $.isFunction(w.ok)&&w.ok||null;
					}else if(!w)delete v.bt[j];
				});
				else v.bt = [];
				$.reIndex(v.bt,1);
			}else if(v.t===2){
				_.th[i] = v = $.extend(true,{},_th2,v);
				if(v.dauto==null)v.dauto = v.auto;
				if(v.dbg==null)v.dbg = v.bg;
			}

			var c,a;
			c = $('<th class="cell '+v.oi+'"></th>');
			//if(v.w)c.css('width',v.w+'px');DEFINE WIDTH
			if(v.o.length){
				var d = $.extend(true,[],v.o);
				a = $('<a href="javascript:;" class="ord'+(v.oi?' ord-'+v.oi:'')+'"></a>').text(v.n).click(function(){
					if($(this).hasClass('ord-index-0'))d[0][1] = $(this).hasClass('az')?false:true;
					else d = $.extend(true,[],v.o);
					setOrd(_,d);
				});
				c.append(a);
			}else c.text(v.n);
			t.append(c);
		});
		$.reIndex(_.th,1);
		set(_);
		setOrd(_,_.o);
	},
	zero = function(_){
		_.e.find('.void').css({display:_.e.find('.tab-lista .lrow:visible').length?'none':''});
	},
	filtro = function(_,f){
		var isf = $.isFunction(f);
		$.each(_.rs,function(i,v){
			$(_.el[v.id]).css('display',(isf?f.call(_,v,i):f)?'':'none');
		});
		zero(_);
	},
	ord = function(_,o){
		var i=0,v;
		if($.type(o)=='string')o = $.sort(o);
		_.o = [];
		for(;v=o[i++];)if($.inArray(v[0],_.oi)+1)_.o.push(v);
		if(!_.ajax)$.sort(_.rs,_.o);
	},
	setOrd = function(_,o){
		var e,l = _.e.find('.tab-lista');
		if(_.lb)return;
		if(o!=null)ord(_,o);
		_.e.find('.lrow.th .ord').removeClass('az za ord-index-0');
		$.each(_.o,function(i,v){
			if(i==0)e = _.e.find('.lrow.th .ord-'+v[0]).addClass(v[1]?'az':'za');
			if(i==0)e.addClass('ord-index-0');
		});
		if(_.ajax)busca(_);
		else if(_.o.length){
			$.each(_.rs,function(i,v){
				l.append(_.el[v.id]);
			});
		}
	},
	busca = function(_,p){
		var fbt,c,d = {ord:'',pg:p||1},e = _.e,_debug;
		if(_.lb)return false;
		$.each(_.o,function(i,v){
			d.ord += (i?',':'')+v[0]+(v[1]?'':' desc');
		});
		if($.isFunction(_.c.fn))c = _.c.fn(d);
		if($.type(c)=='object')$.extend(d,c);
		_.lb = 1;
		fbt = $(_.c.fbt).addClass('load2').attr('title','Carregando...');
		e.find('.void').css('display','none');
		e.find('.loading').css('display','');
		$.post('ajax/g/'+_.c.a+'.json',$.param(d),function(x){
			//if(x.m)alert(x.m);
			if(x.m){
				$('#sys-notification').show();
				var answer = x.ok==1?'success':'danger';
				var icon = x.ok==1?'check':'question';
				$('#notification').html('<div class="alert alert-'+answer+'"><i class="fa fa-'+icon+'-circle"></i> '+x.m+'<button type="button" class="close" data-dismiss="alert">×</button></div>');
				$("html, body").animate({scrollTop:100},600);
			}
			if(x.ok){
				if($.isArray(x.r))_.rs = x.r;
				set(_);
				if(x.qo!=null)$('.filtro-q').val(x.qo);
				if(x.p){
					e.find('.reg-encontrado').html(x.p.q);
					e.find('.pagina-atual').html(x.p.c);
					e.find('.pagina-total').html(x.p.b);
					e.find('.paginacao-buts').html(x.ps).find('a').attr('href','javascript:;').click(function(){
						busca(_,parseInt($(this).attr('pgn'),10));
					});
				}
				if(_.debugBusca){
					var r = '',s = '';
					if(_.debugBusca>1&&x.p)for(var k in x.p)r += k+'='+x.p[k]+'\n';
					if(_.debugBusca>2&&$.isArray(x.r)&&x.r[0])for(var k in x.r[0])s += k+'='+x.r[0][k]+'\n';
					_debug = 'SQL => '+x.sql+'\n\nSQL COUNT => '+x.sql_count+(r?'\n\n'+r:'')+(s?'\n\n'+s:'');
				}
			}
		},'json').complete(function(x){
			_.lb = 0;
			fbt.removeClass('load2').attr('title','Pesquisar...');
			//e.find('.tab-lista').css('display','');
			e.find('.loading').css('display','none');
			zero(_);
			if(_.debugBuscaText)alert(x.responseText);
			if(_.debugBuscaXML)alert(x.responseXML);
			if(_.debugBusca)'_debugBusca' in _?_._debugBusca = _debug:alert(_debug);
		});
		return false;
	}
	set = function(_){
		var l = _.e.find('.tab-lista').html('');
		_.RS = {};
		_.el = {};
		var qodd = 0;
		l.append('<tr class="lrow even" style="background:#eee9d5">'+
	'<!--<td class="cell massa"><span class="ico iunblock" title="Desativar"></span> <a class="ico ialt" title="Alterar" href="admin/complementar/39582"></a> <span class="ico idel" title="Excluir"></span></td>-->'+
	'<td class="cell massa"><input type="checkbox" title="Selecionar todos" class="form-control selectall" style="height:20px"/></td>'+
	'<td class="cell massa line lina"><input type="text" class="form-control" name="cod_produto" id="cod_produto"></td>'+
	'<td class="cell massa line lina"><input type="text" class="form-control" name="desc_mat" id="desc_mat"></td>'+
	'<td class="cell massa line lina"><input type="text" class="form-control" name="qtd_estoque" id="qtd_estoque"></td>'+
	'<td class="cell massa line lina"><input type="text" class="form-control" name="unid_med" id="unid_med"></td>'+
	'<td class="cell massa line lina"><input type="text" class="form-control" name="val_compra" id="val_compra"></td>'+
	'<td class="cell massa line lina"><select class="form-control fn" name="idf" id="idf"></select></td>'+
	'<td class="cell massa line lina"><select class="form-control cla" name="clas_fiscal" id="clas_fiscal"></td>'+
	'<td class="cell massa line lina"><input type="text" class="form-control" name="sit_trib" id="sit_trib"></td>'+
	'<td class="cell massa line lina"><input type="text" class="form-control" name="ide_origem" id="ide_origem"></td>'+
	'<td class="cell massa line lina"><input type="text" class="form-control" name="des_obs" id="des_obs"></td>'+
	'<td class="cell massa line lina"><input type="text" class="form-control" disabled="disabled"/></td>'+
'</tr>');
		if($.isArray(_.rs))$.each(_.rs,function(i,v){
			qodd++;
			var r = $('<tr class="lrow'+(_.img?' img':'')+(qodd%2==0?' even':' odd')+'" _id="'+v.id+'"></tr>');
			$.each(_.th,function(j,w){
				var c = $('<td class="cell individual"></td>'),
				txt = $.trim(v[w.tt])||$.trim(v[w.dtt])||w.tta||'';
				//if(w.w)c.css('width',w.w+'px');

				if(w.t===0){
					var a = w.a||'',b = w.b||'',C = v[w.c]||'',url = a+C+b;
					url = C?url:w.d?a+w.d+b:'';
					if(url){
						url = $('<a></a>').attr({href:url,target:w.tb?'_blank':''}).text(txt);
						c.append(url);
					}else{
						input = $('<input type="text" class="form-control '+w.tt+'" name="'+w.tt+'-'+v.id+'" _id="'+v.id+'" id="'+w.tt+'-'+v.id+'">').attr({value:txt});
						c.append(input);
					}
					if(w.l)c.addClass('line lina');
				}else if(w.t===1){
					$.each(w.bt,function(k,x){
						if(x==' '){
							c.append(' ');
							return;
						}
						var l,m,i,t,f,a,id,b,bt;

						if($.type(x)=='object'){
							l = x.l?true:false;
							tb = l&&x.tb?true:false;
							m = x.m;
							i = x.i||'';
							t = x.t||'';
							f = x.f||null;
							a = x.a||_.c.add||'';
							id = x.id;
							b = x.b||'';
							id = id===undefined?v.id:id===null?'':id;
							if($.type(m)=='string')m = v[m];
							if($.type(m)=='number'){
								if($.isArray(i))i = x.i[m]||'';
								if($.isArray(t))t = x.t[m]||'';
								if($.isArray(f))f = x.f[m]||'';
								if($.isArray(a))a = x.a[m]||'';
								if($.isArray(id))id = x.id[m]||'';
								if($.isArray(b))b = x.b[m]||'';
							}
							bt = $('<'+(l?'a':'span')+' class="ico '+i+'" title="'+t+'" '+(l?'href="'+a+id+b+'"'+(tb?' target="_blank"':''):'')+'></'+(l?'a':'span')+'>');
							if($.isFunction(f))bt.click(function(){
								f.call(_,this,_.c,v,w,x);
							});
						}
						c.append(bt);
					});
				}else if(w.t===2){
					var a = w.a||'',b = w.b||'',C = v[w.c]||'',url = a+C+b;
					url = C?url:w.d?a+w.d+b:'';
					if(url){
						url = $('<a></a>').attr({href:url,target:w.tb?'_blank':''}).text(txt);
						c.append(url);
					}else{
						//input = $('<select class="form-control" name="'+w.tt+'-'+v.id+'"></select>').attr({value:txt});
						input = $('<select class="form-control fn" _id="'+v.idf+'" name="'+w.tt+'-'+v.id+'" id="'+w.tt+'-'+v.id+'"></select>');
						//option = $('<option class="idf-'+v.id+'"></option>').attr({value:v.id_fornecedor}).text(txt);
						//input.append(option);
						c.append(input);
					}
					if(w.l)c.addClass('line lina');
				}else if(w.t===3){
					var a = w.a||'',b = w.b||'',C = v[w.c]||'',url = a+C+b;
					url = C?url:w.d?a+w.d+b:'';
					if(url){
						url = $('<a></a>').attr({href:url,target:w.tb?'_blank':''}).text(txt);
						c.append(url);
					}else{
						//input = $('<select class="form-control" name="'+w.tt+'-'+v.id+'"></select>').attr({value:txt});
						input = $('<select class="form-control cla" _id="'+v.idc+'" name="'+w.tt+'-'+v.id+'" id="'+w.tt+'-'+v.id+'"></select>');
						//option = $('<option class="idf-'+v.id+'"></option>').attr({value:v.id_fornecedor}).text(txt);
						//input.append(option);
						c.append(input);
					}
					if(w.l)c.addClass('line lina');
				}else if(w.t===4){
					var a = w.a||'',b = w.b||'',C = v[w.c]||'',url = a+C+b;
					url = C?url:w.d?a+w.d+b:'';
					if(url){
						url = $('<a></a>').attr({href:url,target:w.tb?'_blank':''}).text(txt);
						c.append(url);
					}else{
						input = $('<input type="text" disabled="disabled" class="form-control" name="'+w.tt+'-'+v.id+'" _id="'+v.id+'" id="'+w.tt+'-'+v.id+'">').attr({value:txt});
						c.append(input);
					}
					if(w.l)c.addClass('line lina');
				}else if(w.t===5){
					var a = w.a||'',b = w.b||'',C = v[w.c]||'',url = a+C+b;
					url = C?url:w.d?a+w.d+b:'';
					if(url){
						url = $('<a></a>').attr({href:url,target:w.tb?'_blank':''}).text(txt);
						c.append(url);
					}else{
						input = $('<input type="checkbox" class="form-control '+w.tt+'" name="'+w.tt+'-'+v.id+'" _id="'+v.id+'" id="'+w.tt+'-'+v.id+'" style="height:20px">').attr({value:txt});
						c.append(input);
					}
					if(w.l)c.addClass('line lina');
				}
				if(w.tit&&txt)c.attr('title',txt);
				r.append(c);
			});
			l.append(r);
			_.RS[v.id] = v;
			_.el[v.id] = r;
		});
		zero(_);
	},

	fn = {
		e:null,load:0,v:'',img:0,ajax:0,o:'',oi:[],th:[],rs:[],RS:{},el:{},lb:0,
		c:{
			_:null,a:'',mt:'',ls:{},ld:{},lo:0,fbt:null,fn:null
		},
		init:function(){
			return init(this);
		},
		zero:function(){
			return zero(this);
		},
		filtro:function(f){
			return filtro(this,f);
		},
		ord:function(o){
			return ord(this,o);
		},
		setOrd:function(o){
			return setOrd(this,o);
		},
		busca:function(p){
			return busca(this,p);
		},
		set:function(){
			return set(this);
		}
	};

	$.tab = function(o){
		var _ = $.extend(true,{},fn,o||{});
		_.c._ = _;
		if(!_.load)$(function(){
			init(_);
		});
		if(_.load===1)init(_);
		return _;
	};
})(jQuery);